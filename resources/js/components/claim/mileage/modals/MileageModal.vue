<template>
    <!-- Modal -->
    <div id="mileageModal" class="modal fade" role="dialog">
        <slot></slot>
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a mileage item</h4>
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
                                        required
                                        readonly
                                />
                            </template>
                            <v-date-picker v-model="date" no-title @input="menu2 = false"></v-date-picker>
                        </v-menu></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date of travel"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Time</div>
                        <div class="col-md-6">
                            <v-dialog
                                    ref="dialog"
                                    v-model="menu1"
                                    :return-value.sync="time"
                                    persistent
                                    width="400px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                            v-model="time"
                                            label="Select time"
                                            v-on="on"
                                            :rules="timeRules"
                                            required
                                    />
                                </template>
                                <v-time-picker
                                        v-if="menu1"
                                        v-model="time"
                                        full-width
                                        :landscape="$vuetify.breakpoint.smAndUp"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu1 = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.dialog.save(time)">OK</v-btn>
                                </v-time-picker>
                            </v-dialog></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Time" data-content="The time of travel"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Vehicle</div>
                        <div class="col-md-6">
                            <v-text-field
                                v-model="vehicle"
                                label="Car Registration"
                                v-on="on"
                                :rules="vehicleRules"
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Vehicle" data-content="The car registration"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Mileage type</div>
                        <div class="col-md-6">
                            <v-select
                                v-model="mtype"
                                :items="mileagetype"
                                label="Mileage Type"
                                item-text="name"
                                item-value="id"
                                :rules="mtypeRules"
                                dense
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Mileage Type" data-content="Business or training mileage"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">From</div>
                        <div class="col-md-6">
                            <v-text-field
                                v-model="from"
                                label="Origin"
                                :rules="fromRules"
                                v-on="on"
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="From" data-content="The origin of your journey"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">To</div>
                        <div class="col-md-6">
                            <v-text-field
                                v-model="to"
                                label="Destination"
                                :rules="toRules"
                                v-on="on"
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="To" data-content="The destination of your journey"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">Reason</div>
                        <div class="col-md-6">
                            <v-text-field
                                v-model="reason"
                                label="Reason"
                                :rules="reasonRules"
                                v-on="on"
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Reason" data-content="The reason for this mileage claim"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                    <div class="row" style="padding:5px; margin-bottom:5px;">
                        <div class="col-md-4">Mileage</div>
                        <div class="col-md-6">
                            <v-text-field
                                    append-icon="Miles"
                                v-model="amount"
                                label="Mileage"
                                :rules="amountRules"
                                type="number"
                                v-on="on"
                                required
                        /></div>
                        <div class="col-md-1 pull-right">
                            <a href='#' class="lead" data-toggle="popover" title="Mileage" data-content="The total mileage of this entry"><span class="fa fa-question-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <v-btn
                            v-if="mileageItem === 0"
                            :disabled="!valid"
                            class="mr-4 btn btn-primary"
                            @click="validate"
                    >
                        Add item
                    </v-btn>
                    <v-btn
                            v-if="mileageItem > 0"
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
        name: "MileageModal",
        props: ['mileage', 'on', 'mileageItem'],
        data()
        {
            return  {
                date: '',
                time: '',
                vehicle: '',
                mileagetype: [],
                mtype: '',
                from: '',
                to: '',
                reason: '',
                amount: '',
                claim: this.$route.params.id,

                errors:'',

                dateRules: [
                    v => !!v || 'Date of journey is required',
                    v => v !== 'Invalid date' || 'Date must be a date',
                ],
                timeRules: [
                    v => !!v || 'Time of journey is required',
                ],
                vehicleRules: [
                    v => !!v || 'Car registration is required',
                    v => (v && v.length <= 8) || 'Registration must be less than 8 characters',
                ],
                mtypeRules: [
                    v => !!v || 'Mileage type is required',
                ],
                fromRules: [
                    v => !!v || 'Origin is required',
                ],
                toRules: [
                    v => !!v || 'Destination is required',
                ],
                reasonRules: [
                    v => !!v || 'Reason for travel is required',
                ],
                amountRules: [
                    v => !!v || 'Total mileage is required',
                    v => (v && parseFloat(v) > 0) || 'Distance travelled cannot be 0 or less',
                    v => (v && !isNaN(parseFloat(v)) || 'Distance travelled must be a number'),
                ],

                menu1: false,
                isLoading: true,
                menu2: false,
                valid: '',
            }
        },
        methods: {
            parseDate (date) {
                return moment(date).format("L");
            },
            validate (id = null) {
                if(this.$refs.form.validate()){
                    let obj = {};
                    if(!(id === null))
                        obj.id = this.mileageItem;
                    obj.claim = this.$route.params.id;
                    obj.vehicle = this.vehicle;
                    obj.mileageType = this.mtype;
                    obj.mileageDate = this.date;
                    obj.mileageTime = this.date;
                    obj.mileage = parseFloat(this.amount);
                    obj.reason = this.reason;
                    obj.origin = this.from;
                    obj.destination = this.to;
                    if(this.mileageItem > 0)
                    {
                        let updated = this.mileage.find(mileage => mileage.id === this.mileageItem);
                        updated.vehicle = obj.vehicle;
                        updated.mileageType = obj.mileageType;
                        updated.mileageDate = obj.mileageDate;
                        updated.mileageTime = obj.mileageTime;
                        updated.mileage = obj.mileage;
                        updated.reason = obj.reason;
                        updated.origin = obj.origin;
                        updated.destination = obj.destination;
                        //updated.amount = parent.calculateMileage(0.55);
                    }
                    else this.mileage.push(obj);
                    this.onSubmit(this.mileageItem);
                }
            },
            reset () {
                this.$refs.form.reset();
                this.mileageItem = 0;
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
            async onSubmit(id = null) {
                let url = API_BASE_URL+'/claims/travel/mileage';

                //change URL for update
                let update = (!(id === 0 || id === null));
                if (update) url = url + '/' +  id;

                let method = (update) ? 'put' : 'post';
                //console.log(url + update + method);
                //now post
                await axios({
                    method: method,
                    url: url,
                    data: this.$data,
                    params:{remember_token:this.$root.getToken()}
                })
                .then(response => {
                    console.log(response);
                    this.$emit('completed', response.data.data);
                    //reset and handle returned data
                    this.reset();
                    this.resetValidation();
                })
                .catch(error => {
                    // handle authentication and validation errors here
                    console.log(error.response.data.errors);
                    this.errors = error.response.data.errors;
                })
            },
        },
        computed: {
            computedDateFormatted() {
                return this.parseDate(this.date);
            }
        },
        async created()
        {
            try {
                this.moment = moment;
                await axios.get(API_BASE_URL+'/mileagetype').then(response => {
                    this.mileagetype = response.data.data;
                });

                this.isLoading = false;
            }
            catch (e) {

            }
        },
        watch: {
            'mileageItem'() {
                if(this.mileageItem > 0) {
                    let item = this.mileage.find(mileage => mileage.id === this.mileageItem);
                    this.vehicle = item.vehicle;
                    this.mtype = item.mileageType;
                    this.date = item.mileageDate;
                    this.time = item.mileageTime;
                    this.amount = item.mileage;
                    this.reason = item.reason;
                    this.from = item.origin;
                    this.to = item.destination;
                }
                else this.reset();
            },
        },

    }
</script>

<style scoped>

</style>