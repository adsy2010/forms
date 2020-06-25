<template>
    <div id="mileagetypePPMModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add pence per mile amount</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"/>
                        <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div>
                            <h5>IMPORTANT</h5>
                            <p>Implementing a mileage type cost for the current month will <strong><u>NOT</u></strong> be editable and may provide
                                some falsely submitted claim amounts. Before adding a change for the <strong>CURRENT</strong>
                                month, please ensure this is definitely what you wish to do.
                            </p>
                            <p>
                                If there are multiple mileage types for the same period only the latest one will apply.
                            </p>
                        </div>
                        <hr>
                        Mileage type
                        <v-autocomplete
                            v-model="mileageType"
                            :items="mileageTypes"
                            item-text="name"
                            item-value="id"
                            placeholder="Select a mileage type"
                            :rules="typeRules"
                        >
                        </v-autocomplete>
                        Effective from:
                        <v-menu
                                v-model="menu"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="monthDisplay"
                                        label="Date"
                                        v-on="on"
                                        required
                                        readonly
                                        :rules="periodRules"
                                />
                            </template>
                            <v-date-picker :min="this.$moment().format('YYYY-MM')" v-model="date" type="month" no-title @input="menu = false"></v-date-picker>
                        </v-menu>
                        Amount
                        <v-text-field
                                v-model="amount"
                                type="number"
                                placeholder="Enter the amount in pounds and pence e.g. 0.55 for 55 pence"
                                persistent-hint
                                hint="Enter the amount in pounds and pence e.g. 0.55 for 55 pence"
                                :rules="amountRules"
                        >
                        </v-text-field>
                    </div>
                    <div class="modal-footer">
                        <v-btn @click="onSubmit" :disabled="!valid" data-dismiss="modal">Add</v-btn>
                    </div>
                </div>
            </div>
        </v-form>
    </div>
</template>

<script>
    import {ADMIN_URL, API_BASE_URL} from "../../../../config";

    export default {
        name: "AddPPM",
        data(){
            return {
                valid:false,
                isLoading: true,
                mileageTypes:[],
                mileageType: 0,
                date:this.$moment().add(1,'month').format('YYYY-MM'),
                amount:0,
                menu:'',

                periodRules:[
                    v => !!v || 'Effective period must be selected.',
                ],
                typeRules:[
                    v => !!v || 'Mileage type must be selected.',
                ],
                amountRules:[
                    v => !!v || 'An amount should be present.',
                    v => (v && parseFloat(v) > 0) || 'Amount cannot be £0 or less.',
                    v => (v && !isNaN(parseFloat(v)) || 'Amount must be numerical.'),
                ],
            }
        },
        async created() {
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
            async onSubmit(){
                if(this.$refs.form.validate()){
                    await this.add();
                    this.$emit('refresh');
                    this.$refs.form.reset();
                }
            },
            async add(){
                let dataWrapper = {
                    mileageType: this.mileageType,
                    effectivePeriod: this.date.replace('-',''),
                    amount: this.amount
                }
                await axios({
                    method:'post',
                    url: ADMIN_URL + 'mileagetypes/ppm',
                    data:dataWrapper,
                    params:{remember_token:this.$root.getToken()}
                }).then(response => {
                    if(response.ok) console.log('ok');
                    console.log(response);
                }).catch(err =>{
                    console.log(err);
                });
                console.log(dataWrapper);
            },
            async retrieve(){
                await axios({
                    method: 'get',
                    url: API_BASE_URL + '/mileagetype',
                }).then(response =>{
                    console.log(response);
                    this.mileageTypes = response.data.data;
                }).catch(err => {
                    console.log(err);
                })
            }
        },
        computed:{
            monthDisplay: function () {
                return this.$moment(this.date).format('MMMM YYYY');
            }
        }
    }
</script>

<style scoped>

</style>