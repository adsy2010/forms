<template>
    <!-- Modal -->
    <div id="transportModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a transport item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"/>
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="well">Please use the help buttons if you are not sure what to enter in any of the boxes.</div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Date</div>
                        <div class="col-md-6">
                            <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                            :value="computedDateFormatted"
                                            label="Date"
                                            hint="DD/MM/YYYY format"
                                            persistent-hint
                                            :rules="dateRules"
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="date" no-title @input="menu2 = false"></v-date-picker>
                            </v-menu>
                            </div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date that the transportation was used"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Transport</div>
                        <div class="col-md-6">
                            <v-select
                                    v-model="ttype"
                                    :items="transporttype"
                                    label="Transport Type"
                                    item-text="name"
                                    item-value="id"
                                    :rules="transporttypeRules"
                                    dense
                            ></v-select>
                        </div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Transport type" data-content="The type of transport used"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Amount</div>
                        <div class="col-md-6"><v-text-field
                                prepend-icon="£"
                                v-model="amount"
                                :rules="amountRules"
                                label="Amount"
                                type="number"
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Amount" data-content="The total cost of transport for this entry"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <v-btn
                            v-if="transportItem === 0"
                            :disabled="!valid"
                            class="mr-4 btn btn-primary"
                            @click="validate"
                    >
                        Add item
                    </v-btn>
                    <v-btn
                            v-if="transportItem > 0"
                            :disabled="!valid"
                            class="mr-4 btn btn-primary"
                            @click="validate"
                    >
                        Update item
                    </v-btn>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
        </v-form>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../../../config";

    const moment = require('moment');
    moment.locale('en-gb');
    export default {
        name: "TransportModal",
        props: ['transport', 'transportItem', 'on'],
        data() {

            return  {
                date: '',
                transporttype: [],
                ttype: '',
                amount: '',

                moment: '',
                message: '',
                isLoading: true,
                menu2: false,
                valid: '',

                dateRules: [
                    v => !!v || 'Date of journey is required',
                    v => v !== 'Invalid date' || 'Date must be a date',
                ],
                transporttypeRules: [
                    v => !!v || 'Transportation type is required',
                ],
                amountRules: [
                    v => !!v || 'Total cost of transportation is required',
                    v => (v && parseFloat(v) > 0) || 'Transportation cost cannot be 0 or less',
                    v => (v && !isNaN(parseFloat(v)) || 'Transportation cost must be a number'),
                ],
            }
        },
        computed: {
            computedDateFormatted() {
                return this.parseDate(this.date);
            }
        },
        watch: {
            'transportItem'() {
                if (this.transportItem > 0) {
                    let item = this.transport.find(transport => transport.id === this.transportItem);
                    this.date = item.transportDate;
                    this.ttype = item.transportType;
                    this.amount = item.amount;
                } else this.reset();
            }
        },
        async created()
        {
            try {
                this.moment = moment;
                await axios.get(API_BASE_URL+'/transporttype').then(response => {
                    this.transporttype = response.data.data;
                });

                this.isLoading = false;
            }
            catch (e) {

            }
        },
        methods: {
            parseDate (date) {
                return moment(date).format("L");
            },
            async onSubmit(obj) {
                await axios({
                    method: 'post',
                    url: API_BASE_URL + '/claims/travel/transport',
                    params: {remember_token: this.$root.getToken()},
                    data: this.$data
                })
                    .then(response => {
                        //Add the responses ID for the data to the live object
                        obj.id = response.data.requestId;
                        this.transport.push(obj);
                        this.$forceUpdate();

                        //reset and handle returned data
                        this.date = '';
                        this.ttype = '';
                        this.amount = '';
                        this.$emit('completed', response.data.data);
                        this.resetValidation();
                        this.reset();
                    })
                    .catch(error => {
                        // handle authentication and validation errors here
                        this.errors = error.response.data.errors;
                    })
            },
            validate () {
                if(this.$refs.form.validate()){
                    let obj = { };

                    try{
                        obj.transportDate = this.date;
                        obj.transportType = (parseInt(this.ttype));
                        obj.amount = parseFloat(this.amount);

                        this.transporttype.filter(function(elem){ (obj.transportType === parseInt(elem.id)) ? obj.transport_type_name = elem : null; });

                        this.onSubmit(obj);
                    }
                    catch (e) {
                        console.log(this.transporttype);
                        console.log(e);
                    }
                }
            },
            reset () {
                this.$refs.form.reset();
                this.transportItem = 0;
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },

    }
</script>

<style scoped>

</style>