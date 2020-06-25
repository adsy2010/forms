<template>
    <div v-show="!isLoading">
        <Breadcrumbs></Breadcrumbs>
        <hr>
        <h2>My Authorisations</h2>
        <hr>
        <div>
            <h4 v-if="false">This section is partly for debugging</h4>
            <p v-if="false" v-for="forms in myForms">I am an authoriser in group {{ forms.group_data.name }} for form {{ forms.form_data.name }} which has priority {{ forms.priority }}</p>
            <h4>My forms and authorisation priorities</h4>
            <div class="row" v-show="!isLoading">
                <div class="col-md-3" v-for="forms in myForms">
                    <div class="card">
                        <div class="card-heading bg-secondary text-white text-center p-2"><h5> {{forms.form_data.name}} <hr/> Priority: {{ $moment().localeData().ordinal(forms.priority) }} </h5></div>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <h4>Forms available to be authorised</h4>
        <div>
            <v-btn color="primary" @click="retrieveAuthorisableForms"><span class="fa fa-refresh"></span></v-btn>
        </div>
        <div>
            <table class="table table-hover" v-show="!isLoading">
                <tr>
                    <th>#</th>
                    <th>Submitter</th>
                    <th>Status</th>
                    <th>Form</th>
                    <th>Period</th>
                    <th>Options</th>
                </tr>
                <tr v-for="f in filteredForms" v-if="filteredForms.length > 0">
                    <td>{{f.id}}</td>
                    <td>{{f.uid}}</td>
                    <td>{{f.state}}</td>
                    <td>{{f.name}}</td>
                    <td>{{$moment(f.period, 'YYYYMM').format('MMMM YYYY')}}</td>
                    <td>
                        <v-btn color="primary" @click="review(f.claimsId, f.groupID)">Review</v-btn>
                    </td>
                </tr>
                <tr v-if="!(filteredForms.length>0)"><td colspan="5">There is nothing to authorise at this time.</td></tr>
            </table>
        </div>
    </div>
</template>

<script>
    import {ADMIN_URL, API_BASE_URL, CLAIMS_ROOT_URL} from "../../../config";

    export default {
        name: "MyAuthorisations",
        data(){
            return {
                isLoading: true,
                myForms: {},
                authorisableForms:[],
            }
        },
        async created(){
            this.isLoading = true;
            await this.retrieveMyForms();
            await this.retrieveAuthorisableForms();
            this.isLoading = false;
        },
        methods: {
            async retrieveMyForms(){
                try{
                    await axios({
                       method: 'get',
                       url: ADMIN_URL + 'agf/my',
                       params: {remember_token:this.$root.getToken()}
                    }).then(response => {
                        this.myForms = response.data.data
                    });
                }
                catch (e) {

                }
            },
            async retrieveAuthorisableForms(){
                try{
                    await axios({
                        method:'get',
                        url: API_BASE_URL + CLAIMS_ROOT_URL + 'submissions/authorisation',
                        params: {remember_token:this.$root.getToken()}
                    }).then(response => {
                        this.authorisableForms = response.data.data;
                        console.log(response);
                    })
                }
                catch (e) {

                }
            },
            review(id, groupId){
                this.$router.push({name:'Authorisation Console', params:{'id':id, 'groupId':groupId}});
                console.log(id);
            }
        },
        computed:{
            filteredForms() {
                if(!this.isLoading){
                    return this.authorisableForms.filter((item)=>{
                        return (!item.state.includes('Draft'));
//                        return "Draft".every(v => console.log(item));
                    })
            }
            else{
                return this.authorisableForms;
            }//return !v.claim_status.state.includes('Draft')
            }
        }
    }
</script>
