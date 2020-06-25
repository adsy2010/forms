<template>
    <div v-if="!isLoading">
        <TravelListSummary @make="make" @delete="del" @update="update" @show="show" :travelClaims="travelClaims"></TravelListSummary>
    </div>

</template>

<script>
    import {API_BASE_URL, MY_TRAVEL_CLAIMS_URL} from "../../../config";
    import TravelListSummary from "../mileage/views/TravelListSummary";

    export default {
        name: "TravelClaimDashboard",
        components: {TravelListSummary},
        data(){
            return {
                isLoading: true,
                travelClaims: {},
                graceDays: 10,
            }
        },
        async created(){
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
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
            async make(formData)
            {
                try {
                    await axios({
                        method: 'post',
                        url: API_BASE_URL + '/claim',
                        params: {remember_token: this.$root.getToken()},
                        data: {formId: formData.form, period: formData.period},
                    }).then(response => {
                        console.log(response);
                        if(response.status === 200) {
                            this.retrieve();
                            this.show(response.data.data);
                        }
                    });
                }
                catch(exception)
                {
                    console.log(exception);
                }
            },
            show(id){
                this.$router.push({name:'Travel Claim', params: {id:id}});
            },
            del(){

            },
            update(){

            },
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
        },
    }
</script>