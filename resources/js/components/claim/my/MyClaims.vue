<template>
    <div v-if="!isLoading">
        <Breadcrumbs></Breadcrumbs>
        <hr>
        <h2>Claims</h2>
        <hr>
        <router-link :to="{name:'Claim Select'}" class="btn btn-primary">Start a new claim</router-link><hr>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Form</th>
                <th>Period</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
            <template>
                <tr v-for="claim in claims" v-if="claims.length > 0">
                    <td>{{ claim.id }}</td>
                    <td>{{ claim.claim_user.FirstName }} {{ claim.claim_user.LastName }}</td>
                    <td>{{ claim.claim_form.name }}</td>
                    <td>{{ $moment(claim.period, "YYYYMM").format("MMMM YYYY") }}</td>
                    <td>{{ claim.claim_status.state }}</td>
                    <td>
                        <router-link v-if="claim.claim_status.state.includes('Draft')" :to="{name: routeMatcher(claim.claim_form.name),params:{id:claim.id}}"><div class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span> Continue</div></router-link>
                        <button v-if="claim.claim_status.state.includes('Submitted')" @click="retract(claim.id)" class="btn btn-sm btn-danger"><span class="fa fa-undo"></span> Retract</button>
                        <router-link v-if="claim.claim_status.state.includes('Draft')" :to="{name:''}"><div class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> Delete</div></router-link>
                    </td>
                </tr>
                <tr v-if="!(claims.length > 0)">
                    <td colspan="6">No entries</td>
                </tr>
            </template>


        </table>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../../config";

    export default {
        name: "ClaimSelect",
        data(){
            return {
                'isLoading': true,
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
            },
            async retract(id)
            {
                this.isLoading = true;
                try{
                    await axios({
                        method: "GET",
                        url: API_BASE_URL+'/claims/'+id+'/retract',
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        if(!(response.status === 200))
                            throw new Error('Not successful');
                    }).catch(err => {
                        console.log(err);
                    });
                }
                catch (e)
                {
                    console.log(e);
                }
                await this.retrieve();
                this.isLoading = false;
            },
            routeMatcher(item){
                console.log(item);
                switch(item) {
                    case 'Travel Claim':
                        return 'Travel Claim';
                    case 'Lunchtime Claim':
                        return 'Time Claims';
                    case 'Time Claim':
                        return 'Time Claims';
                }
            }
        },
        watch:{

        }
    }
</script>
