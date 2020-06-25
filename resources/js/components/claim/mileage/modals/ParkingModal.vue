<template>
    <div ref="parkingModal" id="parkingModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a parking item</h4>
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
                        </v-menu></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date of parking"><span class="fa fa-question-circle"></span></a>
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
                            <a href='#' class="lead" data-toggle="popover" title="Amount" data-content="The total cost of parking for this entry"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <v-btn
                            v-if="parkingItem === 0"
                            :disabled="!valid"
                            class="mr-4 btn btn-primary"
                            @click="validate"
                    >
                        Add item
                    </v-btn>
                    <v-btn
                            v-if="parkingItem > 0"
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
        name: "ParkingModal",
        props: ['parking', 'parkingItem', 'on'],
        methods: {
            parseDate (date) {
                return moment(date).format("L");
            },
            async onSubmit(id = null) {
                let url = API_BASE_URL+'/claims/travel/parking';

                //change URL for update
                let update = (!(id === 0 || id === null));
                if (update) url = url + '/' +  id;

                let method = (update) ? 'put' : 'post';
                //console.log(url + update + method);
                //now post
                await axios({
                    method: method,
                    url: url,
                    params: {remember_token: this.$root.getToken()},
                    data: this.$data
                })
                .then(response => {
                    //reset and handle returned data
                    this.date = '';
                    this.amount = '';
                    this.$emit('completed', response.data.data);
                    this.reset();
                    this.resetValidation();
                })
                .catch(error => {
                    // handle authentication and validation errors here
                    this.errors = error.response.data.errors;
                    console.log(error);
                });
            },
            validate () {
                if(this.$refs.form.validate()){

                    let obj = {};
                    obj.parkingDate = this.date;
                    obj.amount = parseFloat(this.amount);
                    if(this.parkingItem > 0)
                    {
                        let updated = this.parking.find(parking => parking.id === this.parkingItem);
                        updated.parkingDate = obj.date;
                        updated.amount = obj.amount;
                    }
                    else this.parking.push(obj);

                    this.onSubmit(this.parkingItem);
                }
            },
            reset () {
                this.$refs.form.reset();
                this.parkingItem = 0;
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },
        data()
        {
            return  {
                id: '',
                date: '',
                amount: '',
                isLoading: true,
                menu2: false,
                valid: '',

                dateRules: [
                    v => !!v || 'Date of parking is required',
                    v => v !== 'Invalid date' || 'Date must be a date',
                ],
                amountRules: [
                    v => !!v || 'Total cost of parking is required',
                    v => (v && parseFloat(v) > 0) || 'Parking cost cannot be £0 or less',
                    v => (v && !isNaN(parseFloat(v)) || 'Parking cost must be a number'),
                ],
            }
        },
        computed: {
            computedDateFormatted() {
                return this.parseDate(this.date);
            }
        },
        watch: {
            'parkingItem'() {
                if(this.parkingItem > 0) {
                    let item = this.parking.find(parking => parking.id === this.parkingItem);
                    this.date = item.parkingDate;
                    this.amount = item.amount;
                }
                else this.reset();
            },
        },

    }
</script>

<style scoped>

</style>