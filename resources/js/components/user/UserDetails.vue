<template>
    <div v-if="!isLoading">
        <Breadcrumbs></Breadcrumbs>
        <div class="well">
            This is your personnel and user information for the
            Mountbatten Services system. If any details do not appear to be correct,
            please flag them by using the "Flag a problem button"
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="thumbnail">
                    <br>
                    <img class="mx-auto d-block rounded-circle" :src="photoAvailable ? '/files/images/staff/'+currentUser.uid+'.jpg' : '/images/staff/placeholder.png'" alt="...">
                    <br><div class="caption">
                    <h3 class="text-center"> {{ currentUser.FirstName }} {{ currentUser.LastName }} </h3>
                    <table class="" style="margin: 0 auto; width: 300px;">
                        <tr v-if="!(currentUser.personneldetails == null)">
                            <td>Personnel Number</td>
                            <td style="text-align:right;">{{ currentUser.personneldetails.personnelNumber }}</td>
                        </tr>
                        <tr v-if="!(currentUser.personneldetails == null)">
                            <td>National Insurance Number</td>
                            <td style="text-align:right;"> {{currentUser.personneldetails.niNumber}} </td>
                        </tr>
                        <tr v-if="!(currentUser.linemanager == null)">
                            <td>Line Manager</td>
                            <td style="text-align:right;">
                                {{currentUser.linemanager.manager.FirstName}}
                                {{currentUser.linemanager.manager.LastName}}
                            </td>
                        </tr>
                        <tr v-if="!(currentUser.staffdetails == null)">
                            <td>Position</td>
                            <td style="text-align:right;"> {{currentUser.staffdetails.position}} </td>
                        </tr>
                        <tr v-if="!(currentUser.staffdetails == null)">
                            <td>Extension</td>
                            <td style="text-align:right;"> {{currentUser.staffdetails.extension}} </td>
                        </tr>

                    </table>
                    <hr>
                    <v-form>
                        <div class="row">
                            <div class="col-md-6"> <strong>First Name</strong>   <v-text-field label="First Name" v-model="currentUser.FirstName" single-line filled disabled /></div>
                            <div class="col-md-6"> <strong>Last Name</strong>   <v-text-field label="Last Name" v-model="currentUser.LastName" single-line filled disabled /></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Email Address</strong>  <v-text-field label="Email Address" v-model="currentUser.email" single-line filled disabled />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div data-toggle="modal" data-target="#flagModal" class="btn btn-danger"><span class="fa fa-flag"></span> Flag a problem</div>
                            </div>
                        </div>
                    </v-form>
                </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {USER_URL} from "../../config";

    export default {
        name: "UserDetails",
        data(){
            return {
                isLoading: true,
                photoAvailable: false,
                currentUser: {
                    FirstName:'',
                    LastName:'',
                    personneldetails: { personnelNumber:'' },
                    team: {},
                    linemanager: { manager:{FirstName:'', LastName:''}},
                    staffdetails: {},  }
            }
        },
        async created(){
            this.isLoading = true;
            await axios({
                method: 'get',
                url: USER_URL,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                this.currentUser = response.data.data.user;
                this.photoAvailable = response.data.data.photo_exists;
            });
            this.isLoading = false;
        }
    }
</script>