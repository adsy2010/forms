<template>
    <div>
        <Breadcrumbs :parents="['My Claims','Claim Select']"></Breadcrumbs>
        <div class="card card-body bg-light">
            Create a new travel claim, continue or scrap an existing draft claim. The grace period for submitting last months claim is {{ graceDays }} days.
        </div>
        <br>

        <div v-if="!(currentPeriodExists && (previousPeriodExists || !allowedPreviousPeriod))" class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;">
                <v-btn
                        v-if="allowedPreviousPeriod && !previousPeriodExists"
                        class="btn btn-primary btn-nav-custom"
                        @click="create(selectedForm,lastPeriod())"
                >
                    Create {{$moment().subtract(1,'month').format("MMMM")}} claim
                </v-btn>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;">
                <v-btn
                        v-if="!currentPeriodExists"
                        class="btn btn-primary btn-nav-custom"
                        @click="create(selectedForm, currentPeriod())"
                >
                    Create {{$moment().format("MMMM")}} claim
                </v-btn>
            </div>
        </div>
        <div class="card card-body bg-light" v-else>
            You are unable to create any new claims at this time as you either already have a claim for the current period or
            you have passed the grace period to submit a claim for the previous period.
        </div>
        <hr>
        <table class="table table-hover">
            <tr>
                <th>Created On</th>
                <th>Period</th>
                <th>Status</th>
                <th>Total</th>
                <th style="width:150px;">Options</th>
            </tr>

            <tr v-if="travelClaims.length > 0" v-for="claim in travelClaims">
                <td> {{ $moment(claim.created_at, "YYYY-MM-DD H:mm:s").format("H:mm \on Do MMMM YYYY") }} </td>
                <td> {{ $moment(claim.period, "YYYYMM").format("MMMM YYYY") }} </td>
                <td> {{ claim.claim_status.state }} </td>
                <td> no total yet </td>
                <td>
                    <router-link v-if="claim.claim_status.state.includes('Draft')" :to="{name: 'Travel Claim',params:{id:claim.id}}"><div class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span> Continue</div></router-link>
                    <router-link v-if="claim.claim_status.state.includes('Submitted')" :to="{name: ''}"><div class="btn btn-sm btn-danger"><span class="fa fa-undo"></span> Retract</div></router-link>
                    <router-link v-if="claim.claim_status.state.includes('Draft')" :to="{name:''}"><div class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></div></router-link>
                </td>
            </tr>

            <tr v-if="!(travelClaims.length > 0)"><td colspan="5">You currently have no unsubmitted travel claims.</td></tr>
        </table>
    </div>

</template>

<script>
    import {API_BASE_URL, MY_TRAVEL_CLAIMS_URL} from "../../../../config";
    import Utility from "../../../Utility";

    export default {
        name: "TravelListSummary",
        data(){
            return {
                isLoading: true,
                graceDays: 10,
                selectedForm: 0,
                forms:{},
            }
        },
        props:['travelClaims'],
        async created(){
            this.isLoading = true;
            this.forms = await Utility.methods.getForms('travel');
            await this.setSelectedForm();
            this.isLoading = false;
        },
        methods:{
            async setSelectedForm(){
                this.selectedForm = (this.forms.length > 0) ? this.forms[0].id : 0;
            },
            create(formId, period){
                this.$emit('make', {period: period, form: formId});
                //this.filterTimeClaims();
            },
            async retrieve(){
                await axios({
                    method: 'get',
                    url: MY_TRAVEL_CLAIMS_URL ,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    console.log(response);
                    this.travelClaims = response.data.data.travelclaims;
                });
            },
            currentPeriod(){
                return parseInt(this.$moment().format("YYYYMM"));
            },
            lastPeriod()
            {
                return parseInt(this.$moment().subtract(1,'month').format('YYYYMM'));
            },
            allowedLastPeriod(){
                let period = parseInt(this.$moment().subtract(this.graceDays,'day').format('YYYYMM'));
                return (period === this.lastPeriod());
            },
            isDraft(state)
            {
                return (state === 'Draft');
            },
            isSubmitted(state)
            {
                return (state === 'Submitted');
            },
            cPeriodExists()
            {
                try{
                    let cp = this.currentPeriod();
                    return (this.travelClaims.filter(function (i) {
                        return (i.period === cp);
                    }).length > 0);
                }
                catch (e) {
                    return false;
                }

            },
            pPeriodExists()
            {
                try{
                    let pp = this.lastPeriod();
                    return (this.travelClaims.filter(function (i) {
                        return (i.period === pp);
                    }).length > 0);
                }
                catch (e) {
                    return false;
                }


            }
        },
        computed: {
            currentPeriodExists()
            {
                if(this.isLoading === false)
                {
                    return this.cPeriodExists();
                }
            },
            previousPeriodExists()
            {
                if(this.isLoading === false)
                {
                    return this.pPeriodExists();
                }
            },
            allowedPreviousPeriod(){
                if(this.isLoading === false)
                {
                    return this.allowedLastPeriod();
                }
            }
        }
    }
</script>

<style scoped>

</style>