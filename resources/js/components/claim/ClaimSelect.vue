<template>
    <div v-if="!isLoading">

        <Breadcrumbs :parents="['My Claims']"></Breadcrumbs>
        <hr>
        <h2>Select a Claim</h2>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'Create Time Claim'}" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-time"></span> Time Claims</router-link></div>
            <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'Create Travel Claim'}" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-time"></span> Travel Claims</router-link></div>
        </div>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../config";

    export default {
        name: "ClaimSelect",
        data(){
            return {
                'isLoading': true,
                'role':'Staff',
                'claims':
                    {
                        'claim_user': { 'FirstName': '','LastName': ''},
                        'claim_form': {},
                        'claim_status':{}
                }
            }
        },
        async created()
        {
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods: {
            async retrieve()
            {
                try{
                    await axios({
                        method: "GET",
                        url: API_BASE_URL+'/claim',
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        this.claims = response.data.data;
                    });
                }
                catch (e)
                {
                    console.log(e);
                }
            }
        },
        watch:{
            role(){if(!(this.role === "Staff")) this.$router.push('/user');}
        }
    }
</script>
