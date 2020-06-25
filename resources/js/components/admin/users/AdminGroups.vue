<template>
    <div>
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <div class="well">
            Groups information
        </div>

        <br>
        <v-text-field label="Search by name" v-model="search" single-line filled :disabled="isLoading"></v-text-field>
        <div class="text-center" v-if="isLoading">Loading...</div>
        <table class="table table-hover" v-if="!isLoading">
            <tr>
                <th>#</th>
                <th>Group Name</th>
                <th>Created</th>
            </tr>


            <tr v-if="filteredGroups.length > 0" v-for="s in filteredGroups" class="clickable-row" @click="openGroup(s.id)">
                <td> {{s.id}} </td>
                <td> {{s.name}} </td>
                <td> {{$moment(s.created_at).format('H:ss - Do MMMM YYYY')}} </td>
            </tr>
            <tr v-if="!(groups.length > 0)"><td colspan="5">No groups in the database.</td></tr>
        </table>
         $groups.links() 
    </div>
</template>

<script>
    import {ADMIN_GROUPS_URL} from "../../../config";

    export default {
        name: "AdminGroups",
        data(){
            return{
                isLoading: true,
                search:'',
                groups: [],
            }
        },
        async created(){
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
            async retrieve(){
                await axios({
                    method: 'get',
                    url: ADMIN_GROUPS_URL,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    this.groups = response.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },
            openGroup(id){
                this.$router.push({ name: 'Admin Group', params: { id: id } });
            }
        },
        computed: {
            filteredGroups(){
                if(this.search){
                    return this.groups.filter((item)=>{
                        return this.search.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                    })
                }else{
                    return this.groups;
                }
            }
        }
    }
</script>

<style scoped>

</style>