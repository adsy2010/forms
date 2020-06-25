<template>
    <div>
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <div class="well">
            User information
        </div>

        <br>
        <br>
        <v-text-field label="Search by name" v-model="search" single-line filled :disabled="isLoading"></v-text-field>
        <div class="text-center" v-if="isLoading">Loading...</div>
        <table class="table table-hover" v-if="!isLoading">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Created</th>
            </tr>

            <tr v-if="filteredUsers.length > 0" v-for="s in filteredUsers" class="clickable-row" @click="openUser(s.id)">
                <td>{{ s.id }}</td>
                <td>{{ s.FirstName }}</td>
                <td>{{ s.LastName }}</td>
                <td>{{ s.email }}</td>
                <td>{{ $moment(s.created_at).format('H:ss - Do MMMM YYYY') }}</td>
            </tr>
            <tr v-if="!(users.length >0)"><td colspan="5">No users in this search.</td></tr>

        </table>
         $users->links()
    </div>
</template>

<script>
    import {ADMIN_USERS_URL} from "../../../config";

    export default {
        name: "AdminUsers",
        data(){
            return{
                isLoading: true,
                users: {},
                search: '',
            }
        },
        async created()
        {
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
            async retrieve(){
                await axios({
                    method: 'get',
                    url: ADMIN_USERS_URL,
                    params: {remember_token: this.$root.getToken()}
                }).then(response =>{
                    this.users = response.data.data.data;
                });
            },
            openUser(id){
                this.$router.push({ name: 'Admin User', params: { id: id } });
            }
        },
        computed: {
            filteredUsers(){
                if(this.search){
                    return this.users.filter((item)=>{
                        return this.search.toLowerCase().split(' ').every(v => (item.FirstName.toLowerCase() +" "+item.LastName.toLowerCase()).includes(v))
                    })
                }else{
                    return this.users;
                }
            }
        }
    }
</script>