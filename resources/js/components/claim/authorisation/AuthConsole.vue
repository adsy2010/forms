<template>
    <div>
        <Breadcrumbs :parents="['My Authorisations']"></Breadcrumbs>
        <hr>
        <h2>Authorisation Console</h2>
        <hr>

        <div class="text-center">
            <v-btn color="success" class="mr-4" @click="approve"><span class="fa fa-check mr-2"></span>  Approve</v-btn>
            <v-btn color="error" class="ml-4" @click="deny"><span class="fa fa-times mr-2"></span>  Reject</v-btn>
        </div>

        <Reviewable :form="currentForm" :claim="currentClaim"></Reviewable>

        <div class="text-center">
            <v-btn color="success" class="mr-4" @click="approve"><span class="fa fa-check mr-2"></span>  Approve</v-btn>
            <v-btn color="error" class="ml-4" @click="deny"><span class="fa fa-times mr-2"></span>  Reject</v-btn>
        </div>
    </div>
</template>

<script>
    import Reviewable from "./Reviewable";
    import {ADMIN_URL, API_BASE_URL, CLAIMS_ROOT_URL} from "../../../config";
    export default {
        name: "AuthConsole",
        components: {Reviewable},
        description: "This component will be a wrapper to display a " +
            "selected form component and will contain approve and deny options for the approval process",
        created(){
              this.isLoading = true;
              if(typeof this.$route.params.id === 'undefined') this.$router.push({name:'My Authorisations'})
              this.retrieve();
              this.isLoading = false;
        },
        data(){
            return {
                isLoading: true,
                currentForm: 0,
                currentClaim: {},
            }
        },
        methods:{
            async retrieve(){
                try{
                    await axios({
                        method:'get',
                        url:API_BASE_URL+CLAIMS_ROOT_URL+this.$route.params.id,
                        params: {remember_token:this.$root.getToken()}
                    }).then(response => {
                        this.currentClaim = response.data.data;
                        this.currentForm = this.currentClaim.claim_form.id;
                    });
                }
                catch (e) {

                }
            },
            approve(){
                //console.log("Approve");
                this.sendResponse(1);
            },
            deny(){
                //console.log("Deny");
                this.sendResponse(0);
            },
            async sendResponse(status){
                try{
                    await axios({
                        method:'post',
                        url: ADMIN_URL + 'aga',
                        params: {remember_token:this.$root.getToken()},
                        data: {'claim':this.currentClaim.id, 'authGroup':this.$route.params.groupId, 'status':status}
                    }).then(response => {
                        //check response is all good then forward
                        if(response.status === 200)
                            this.$router.push({name:'My Authorisations'});
                    }).catch(error => {
                        console.log(error.response.data.error);
                    });
                }catch(e){
                    //console.log(e);
                }

            }
        },
        computed:{

        },
        watch:{

        }
    }
</script>

<style scoped>

</style>