<template>
    <div>
        <div class="card card-body bg-light">
            Create a new time claim, continue or scrap an existing draft claim. The grace period for submitting last months claim is {{ graceDays }} days.
        </div>
        <br>
        <v-switch label="Lunchtime?" v-model="lunchtime"></v-switch>
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
                <th>#</th>
                <th>Created At</th>
                <th>Period</th>
                <th>Status</th>
                <th>Claim total</th>
                <th style="width:150px;">Options</th>
            </tr>

            <tr v-if="filteredItems.length > 0" v-for="claim in filteredItems">
                <td> {{ claim.id }} </td>
                <td> {{ $moment(claim.created_at, "YYYY-MM-DD H:mm:s").format("H:mm \on Do MMMM YYYY") }} </td>
                <td> {{ $moment(claim.period, "YYYYMM").format("MMMM YYYY") }} </td>
                <td> {{ claim.claim_status.state }} </td>
                <td> no total yet </td>
                <td style="text-align: right;">
                    <div v-if="isDraft(claim.claim_status.state)" @click="show(claim.id)" class="btn btn-sm btn-primary text--white">Continue</div>
                    <div v-if="isDraft(claim.claim_status.state) || isSubmitted(claim.claim_status.state)" @click="del(claim.id)" class="btn btn-sm btn-danger text--white"><span class="fa fa-trash-o"></span></div>
                    <p v-if="!isDraft(claim.claim_status.state) && !isSubmitted(claim.claim_status.state)">No options</p>
                </td>
            </tr>

            <tr v-if="!(timeclaims > 0)"><td colspan="6">You currently have no unsubmitted time claims.</td></tr>
        </table>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../../../config";
    import Utility from "../../../Utility";

    export default {
        props: ['timeclaims'],
        name: "HoursListSummary",
        data(){
            return {
                isLoading: true,
                graceDays: 10,
                forms: {},
                lunchtime:false,
                selectedForm: 0,
                filteredTimeClaims: [],
            }
        },
        async created() {
            this.isLoading = true;
            this.forms = await Utility.methods.getForms('time');
            await this.setSelectedForm();
            this.isLoading = false
        },
        methods:{
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
                    return (this.filteredTimeClaims.filter(function (i) {
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
                    return (this.filteredTimeClaims.filter(function (i) {
                        return (i.period === pp);
                    }).length > 0);
                }
                catch (e) {
                    return false;
                }
            },
            filterTimeClaims(){
                if(this.timeclaims.length > 0)
                {
                    this.filteredTimeClaims =
                        (this.lunchtime) ?
                            this.timeclaims.filter(function (i) {
                                return (i.claim_form.name.toLowerCase().includes('lunch'));
                            }) :
                            this.timeclaims.filter(function (i) {
                                return (!i.claim_form.name.toLowerCase().includes('lunch'));
                            });
                    this.setSelectedForm();
                }
            },
            setSelectedForm(){
                this.selectedForm = (this.lunchtime) ?
                    this.forms.filter(function (item)
                    {return (item.name.toLowerCase().includes('lunch'));})[0].id:
                    this.forms.filter(function (item)
                    {return (!item.name.toLowerCase().includes('lunch'));})[0].id;
            },
            create(formId, period){
                this.$emit('make', {period: period, form: formId});
                this.filterTimeClaims();
                },
            del(id){this.$emit('delete', id);},
            update(id){this.$emit('update', id);},
            show(id){this.$emit('show', id);}
        },
        computed: {
            filteredItems(){
                if(this.isLoading === false)
                {
                    return this.filteredTimeClaims;
                }
            },
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
        },
        watch:{
            'lunchtime'(){
                this.filterTimeClaims();
                this.setSelectedForm();
            },
            'timeclaims'(){
                this.filterTimeClaims();
            }
        }
    }
</script>