<template>
    <div>

        <hr>
        <h2>Claim Summary</h2>
        <hr>
        <div class="">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-heading bg-primary p-2"><span class="fa fa-clock-o"></span> Hours</div>
                    <div class="card-body">
                        <v-form
                            ref="form"
                            lazy-validation
                    >
                        <table class="table" style="border-top:0;">
                            <tr>
                                <th>Date</th>
                                <th>Hours</th>
                            </tr>

                            <template>

                                <tr v-for="h in hours" v-if="hours.length > 0" v-bind:key="h.id" :class="($moment(h.claimDate).format('dddd').includes('Saturday') || $moment(h.claimDate).format('dddd').includes('Sunday')) ? 'bg-info' : ''">
                                    <td style="vertical-align: middle;"><strong>{{ $moment(h.claimDate).format("dddd Do MMMM") }}</strong></td>
                                    <td><v-text-field
                                            v-model="h.hours"
                                            label="Amount"
                                            type="number"
                                    />
                                    </td>
                                </tr>
                            </template>

                            <template v-if="sizeOfObj(hours) === 0">
                                <tr><td colspan="6">No items</td></tr>
                            </template>
                        </table>
                            <v-btn
                                class="mr-4 btn btn-primary"
                                :disabled="!saveable"
                                @click="onSave"
                        >
                            Save hours
                        </v-btn>
                            <v-btn
                                class="mr-4 btn btn-secondary"
                                :disabled="!saveable"
                                @click="onSubmit"
                        >
                            Submit
                        </v-btn>
                        </v-form>
                    </div>
                    <div class="card-footer">Total Hours Claimed - {{ totalHours }}</div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {API_BASE_URL, CLAIMS_ROOT_URL, MY_TIME_CLAIMS_URL} from "../../../../config";

    export default {
        props: ['claim', 'id'],
        name: "HoursClaimItem",
        data()
        {
            return{
                isLoading: true,
                hours: {},
                claimData: {},
                saveable: false,
            }
        },
        created()
        {
            this.isLoading = true;
            //console.log(this.$props);
            //if(typeof this.$props.claim === 'undefined') this.$router.push({name:'Create Time Claim'})
            this.retrieve();
            this.isLoading = false;
        },
        methods: {
            async retrieve(){
                try {
                    await axios({
                        method:'get',
                        url: MY_TIME_CLAIMS_URL + 't/'+ this.$props.id ,
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        this.hours = response.data.data;
                    });

                }
                catch (e) {
                    console.log(e.message);
                }
                await this.retrieveClaim();
            },
            async retrieveClaim(){
                try{
                    await axios({
                        method: 'get',
                        url: API_BASE_URL + CLAIMS_ROOT_URL + this.$props.id,
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        this.claimData = response.data.data;

                    });
                }
                catch (e) {

                }
            },
            async update(){
                let url = API_BASE_URL+'/claims/time';

                //change URL for update
                //let id = 1;
                let update = true;//(!(id === 0 || id === null));
                if (update) url = url + '/t/' +  this.$props.id;

                let method = (update) ? 'put' : 'post';

                await axios({
                    method: method,
                    url: url,
                    params: {remember_token: this.$root.getToken()},
                    data: {'data': this.$data.hours}
                });
            },
            sizeOfObj(value) {
                return value.length;
            },
            calculateHours() {
                let sum = 0;
                this.hours.forEach(e => {
                    sum += parseFloat(e.hours);
                });
                return sum;
            },
            validate(){
                return !!this.$refs.form.validate();
            },
            onSave(){
                if(this.validate()) {
                    this.update();
                }//no returned data here required.
            },
            onSubmit()
            {
                this.onSave(); //save first

                //now submit
                this.$emit('submit', this.$props.id);
                this.retrieveClaim();
                this.$router.go(); //refreshes back to the dashboard
            }
        },
        computed: {
            totalHours: function() {
                if(this.hours.length > 0)
                    return this.calculateHours();
                else return 0;
                //return 0;
            },
        },
        watch: {
            'claimData.claim_status.state'(){
                let state = this.claimData.claim_status.state;
                this.saveable = (state.includes('Draft'));
            },
            'claim'(){
                this.retrieve();
            }
        }
    }
</script>
