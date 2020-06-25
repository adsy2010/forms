<template>
    <div>
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <Status @clicked='closeStatus' :status="status" />

        <v-form ref="usersession" v-model="isValid">
                <div class="row">
                    <div class="col-md-6">
                        <v-text-field
                                v-model="username"
                                label="Username"
                                single-line
                                filled
                                :rules="[v => !!v || 'Username is required']"
                                :disabled="isLoading"
                                required
                        ></v-text-field>
                    </div>
                    <div class="col-md-6">
                        <v-text-field
                                v-model="token"
                                label="Token"
                                single-line
                                filled
                                :rules="[v => !!v || 'Token is required']"
                                :disabled="isLoading"
                                required
                        ></v-text-field>
                    </div>
                </div>
                <v-btn class="btn btn-primary" @click="createSession" :disabled="!isValid">Create Custom Token!</v-btn>
        </v-form>

        <hr>
        <div class="well">
            All user sessions are created and used almost instantly under regular use.
            Occasionally sessions may be left behind or a login link may be needed.
            Use this page for this.
        </div>
        <br>
        <v-btn class="btn btn-danger" @click="truncate" :disabled="isLoading">Purge unused sessions</v-btn>
        <v-btn class="btn btn-info" @click="retrieve" :disabled="isLoading"><span class="fa fa-refresh"></span></v-btn>
        <br>
        <br>
        <div class="text-center" v-if="isLoading">Loading...</div>
        <table class="table table-responsive" v-if="!isLoading">
            <tr>
                <th>#</th>
                <th>UID</th>
                <th>Token</th>
                <th>Created</th>
                <th>Token link</th>
            </tr>


            <tr v-for="s in usersession">
                <td> {{s.id}} </td>
                <td> {{s.uid}} </td>
                <td> {{s.token}} </td>
                <td> {{$moment(s.created_at).format('H:mm - Do MMMM YYYY')}} </td>
                <td><a :href="loginURL+s.uid+'/'+s.token">LINK</a></td>
            </tr>
            <tr v-if="!(usersession.length > 0)"><td colspan="5">No sessions in the database.</td></tr>

        </table>
    </div>
</template>

<script>
    import {ADMIN_SESSIONS_URL, SITE_BASE_URL} from "../../../config";
    import Status from "../../Status";

    export default {
        name: "AdminUserSessions",
        data(){
            return {
                isLoading:true,
                usersession: {},
                loginURL: SITE_BASE_URL + '/login/',

                status:{status:'', message:''},

                //create session vars
                username: '',
                token: '',
                isValid: true,
            }
        },
        async created(){
                this.isLoading = true;
                await this.retrieve();
                this.isLoading = false;
        },
        methods:{
            closeStatus(){
                this.status.status = '';
                this.status.message = '';
            },

            /**
             * Creates a new session
             * @returns {Promise<void>}
             */
            async create(){

            },
            /**
             * Reads sessions from database
             * @returns {Promise<void>}
             */
            async retrieve(){
                await axios({
                    method: 'get',
                    url: ADMIN_SESSIONS_URL,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    this.usersession = response.data.data;
                });
            },
            /**
             * Updates sessions in database (unused)
             * @returns {Promise<void>}
             */
            async update(id){

            },
            /**
             * Deletes session from database
             * @returns {Promise<void>}
             */
            async delete(id){

            },
            /**
             * Truncates all sessions from database
             * @returns {Promise<void>}
             */
            async truncate(){
                this.isLoading = true;
                await axios({
                    method: 'delete',
                    url: ADMIN_SESSIONS_URL
                }).then(response => {
                    this.read();
                });

                this.isLoading = false;
            },

            async createSession(){
                this.isLoading = true;
                if(this.isValid) {
                    try{
                        await axios({
                            method: 'POST',
                            url: ADMIN_SESSIONS_URL + 'create',
                            data: {
                                username: this.username,
                                token: this.token
                            }
                        }).then(response => {
                            this.status.status = response.status.toString();
                            this.status.message = response.data.status;
                            this.$refs.usersession.reset();
                            this.$refs.usersession.resetValidation();
                            this.read();
                        });
                    }
                    catch(error) {
                        this.status.status = error.response.status.toString();
                        this.status.message = error.response.data.status;
                    }
                }
                this.isLoading = false;
            },
        }
    }
</script>
