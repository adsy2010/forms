<template>
    <!-- Modal -->
    <div id="subsistenceModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a subsistence item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"/>
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="well">Please use the help buttons if you are not sure what to enter in any of the boxes.</div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Date</div>
                        <div class="col-md-6">                            <v-menu
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
                        </v-menu></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date of subsistence"><span class="fa fa-question-circle"></span></a>
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
                            <a href='#' class="lead" data-toggle="popover" title="Amount" data-content="The total amount of subsistence"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <v-btn
                            v-if="subsistenceItem === 0"
                            :disabled="!valid"
                            class="mr-4 btn btn-primary"
                            @click="validate"
                    >
                        Add item
                    </v-btn>
                    <v-btn
                            v-if="subsistenceItem > 0"
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
        name: "SubsistenceModal",
        props: ['subsistence', 'subsistenceItem', 'on'],
        data()
        {
            return  {
                date: '',
                amount: '',

                isLoading: true,
                menu2: false,
                valid: '',

                dateRules: [
                    v => !!v || 'Date of subsistence is required',
                    v => v !== 'Invalid date' || 'Date must be a date',
                ],
                amountRules: [
                    v => !!v || 'Total subsistence cost is required',
                    v => (v && parseFloat(v) > 0) || 'Subsistence cost cannot be £0 or less',
                    v => (v && !isNaN(parseFloat(v)) || 'Subsistence cost must be a number'),
                ],

            }
        },
        methods: {
            parseDate (date) {
                return moment(date).format("L");
            },
            async onSubmit(id = null) {
                let url = API_BASE_URL+'/claims/travel/subsistence/';

                //change URL for update
                if(!(id === null)) url += id;

                //now post
                await axios({
                    method: 'post',
                    url: url,
                    params: {remember_token: this.$root.getToken()},
                    data: this.$data
                })
                    .then(response => {
                        //reset and handle returned data
                        this.date = '';
                        this.amount = '';
                        this.$emit('completed', response.data.data);
                        this.resetValidation();
                        console.log(response);
                    })
                    .catch(error => {
                        // handle authentication and validation errors here
                        this.errors = error.response.data.errors;
                    })
            },
            validate (id = null) {
                if(this.$refs.form.validate()){
                    let obj = {};
                    if(!(id === null))
                        obj.id = this.subsistenceItem;
                    obj.subsistenceDate = this.date;
                    obj.amount = parseFloat(this.amount);
                    this.subsistence.push(obj);
                    this.onSubmit();
                }
            },
            reset () {
                this.$refs.form.reset();
                this.subsistenceItem = 0;
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },
        watch: {
            'subsistenceItem'() {
                if(this.subsistenceItem > 0) {
                    let item = this.subsistence.find(subsistence => subsistence.id === this.subsistenceItem);
                    this.date = item.subsistenceDate;
                    this.amount = item.amount;
                }
                else this.reset();
            },
        },
        computed: {
            computedDateFormatted() {
                return this.parseDate(this.date);
            }
        },
    }
</script>

<style scoped>

</style>