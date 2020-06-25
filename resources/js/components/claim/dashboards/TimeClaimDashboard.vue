<template>
    <div>
        <Breadcrumbs :parents="['My Claims','Claim Select']"></Breadcrumbs>
        <HoursListSummary v-if="!(claim > 0)" @make="make" @delete="del" @update="update" @show="show" :timeclaims="timeclaims"></HoursListSummary>
        <HoursClaimItem v-else :id="claim" @submit="submit"></HoursClaimItem>
    </div>

</template>

<script>

    import {API_BASE_URL, CLAIMS_ROOT_URL, MY_TIME_CLAIMS_URL} from "../../../config";
    import HoursListSummary from "../time/views/HoursListSummary";
    import HoursClaimItem from "../time/views/HoursClaimItem";

    export default {
        name: "TimeClaimDashboard",
        components: {HoursListSummary, HoursClaimItem},
        data(){
            return {
                isLoading: true,
                graceDays: 10,
                timeclaims: {},
                claim:0,
            }
        },
        created(){
            this.isLoading = true;
            if(!(typeof this.$route.params.claim === 'undefined')) this.claim = this.$route.params.claim;
            this.retrieve();
            this.isLoading = false;
        },
        methods:{
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
            async retrieve(){
                await axios({
                    method: 'get',
                    url: MY_TIME_CLAIMS_URL ,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    //console.log(response);
                    this.timeclaims = response.data.data.timeclaims;
                });
            },
            show(id)
            {
                this.claim = id;
            },
            del(id)
            {

            },
            update(id)
            {

            },
            async submit(id){
                try{
                    await axios({
                        method: 'put',
                        url: API_BASE_URL + '/claim/' + id,
                        params: {remember_token:this.$root.getToken()},
                        data:{'status':'Submitted'}
                    }).then(response => {
                        //console.log(response);
                        this.createSubmission(id);
                    });
                }catch (e) {
                    console.log(e);
                }
            },
            async createSubmission(id){
                try{
                    await axios({
                        method:'post',
                        url: API_BASE_URL+'/claims/submissions',
                        params: {remember_token:this.$root.getToken()},
                        data: {claim:id}
                    }).then(response => {
                        console.log(response);
                    });
                }
                catch (e) {
                    console.log(e);
                }
            },
            async unsubmit(id){
                try{
                    axios({
                        method: 'put',
                        url: API_BASE_URL + '/claim/' + id,
                        params: {remember_token:this.$root.getToken()},
                        data:{'status':'Draft'}
                    });
                }catch (e) {

                }
            }
        }
    }
</script>