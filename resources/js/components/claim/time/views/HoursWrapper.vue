<template>
    <div>
        <Breadcrumbs :parents="['My Claims','Claim Select']"></Breadcrumbs>
        <HoursListSummary v-if="!(id > 0)" @make="make" @delete="del" @update="update" @show="show" :timeclaims="timeclaims"></HoursListSummary>
        <HoursClaimItem v-else :id="id" @submit="submit"></HoursClaimItem>
    </div>
</template>

<script>
    import HoursClaimItem from "./HoursClaimItem";
    import HoursListSummary from "./HoursListSummary";
    import {API_BASE_URL} from "../../../../config";

    export default {
        name: "HoursWrapper",
        components: {HoursListSummary, HoursClaimItem},
        props: ['id'],
        created(){

        },
        data(){
            return {
                timeclaims: {},
            };
        },
        methods:{
            make(){

            },
            del(){

            },
            update(){

            },
            show(){

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
        }
    }
</script>

<style scoped>

</style>