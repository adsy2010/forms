<template>
    <div>
        <AdminBreadcrumbs :parents="['Admin Users']"></AdminBreadcrumbs>
        <div class="well">
            Your user information summary is below. If you believe any information is
            incorrect please flag the user and add notes for any details that
            cannot be changed as some details are centrally managed on a different system.
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="thumbnail">
                    <br>
                    <h4>
                        <span v-if="role.includes('Parent')" class="float-left badge badge-secondary" style="background-color:purple;">Parent</span>
                        <span v-if="role.includes('Staff')" class="float-left badge badge-secondary" style="background-color:orange;">Staff</span>
                        <span v-if="role.includes('Ofsted') " class="float-left badge badge-secondary" style="background-color:navy;">Ofsted</span>
                        <span v-if="role.includes('Student') " class="float-left badge badge-secondary" style="background-color:yellow; color:black;">Student</span>
                    </h4>
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
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div v-if="role != 'Students'" data-toggle="modal" data-target="#changeLMModal" style="margin-top:14px;" class="btn btn-warning"><span class="fa fa-paw"></span> Change Line Manager</div>
                            <div data-toggle="modal" data-target="#changePhotoModal" style="margin-top:14px;" class="btn btn-warning"><span class="fa fa-camera"></span> Change photo</div>
                            <div v-if="role != 'Students'" data-toggle="modal" data-target="#changePIModal" style="margin-top:14px;" class="btn btn-warning"><span class="fa fa-credit-card"></span> Change personnel info</div>
                            <div data-toggle="modal" data-target="#flagModal" style="margin-top:14px;" class="btn btn-danger"><span class="fa fa-flag"></span> Flag user</div>
                        </div>
                    </div>

                </div>
                </div>
            </div>
        </div>



        <br>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>AD Group</th>
                <th>Last change</th>
            </tr>

            <tr v-if="currentUser.groupmemberships.length > 0" v-for="groups in currentUser.groupmemberships" class="clickable-row" data-href=" Route('admin.group.view', $s->groupInfo->id) ">
                <td> {{groups.group_info.id}} </td>
                <td> {{groups.group_info.name}} </td>
                <td> {{$moment(groups.updated_at).format('H:ss \on Do MMMM YYYY')}} </td>
            </tr>

            <tr v-if="!(currentUser.groupmemberships.length > 0)"><td colspan="5">No groups in the database for this user.</td></tr>
        </table>
        <ChangeLineManager :currentUser="currentUser"></ChangeLineManager>
        <ChangePhoto :photoAvailable="photoAvailable" :currentUser="currentUser"></ChangePhoto>
        <ChangePersonnelInfo :currentUser="currentUser"></ChangePersonnelInfo>
    </div>
</template>

<script>
    import {ADMIN_USERS_URL, USER_URL} from "../../../config";
    import ChangeLineManager from "./modals/ChangeLineManager";
    import ChangePhoto from "./modals/ChangePhoto";
    import ChangePersonnelInfo from "./modals/ChangePersonnelInfo";

    export default {
        name: "AdminUser",
        components: {ChangePersonnelInfo, ChangePhoto, ChangeLineManager},
        data(){
            return {
                isLoading: true,
                currentUser: {
                    FirstName:'',
                    LastName:'',
                    personneldetails: { personnelNumber:'' },
                    team: {},
                    linemanager: { manager:{FirstName:'', LastName:''}},
                    staffdetails: {},
                    groupmemberships: { group_info: { name: ''}},
                },
                photoAvailable: false,
                role: '',
            }
        },
        async created(){
            this.isLoading = true;
            await axios({
                method: 'get',
                url: ADMIN_USERS_URL + this.$route.params.id,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                this.currentUser = response.data.data.user;
                this.photoAvailable = response.data.data.photo_exists;
                this.role = response.data.data.role;
            });
            this.isLoading = false;
        }
    }
</script>
