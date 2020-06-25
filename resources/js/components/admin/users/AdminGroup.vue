<template>
    <div>
        <AdminBreadcrumbs :parents="['Admin Groups']"></AdminBreadcrumbs>
        <div class="well">
            Group information
        </div>
        <br>
        <div> {{g.name}} </div>

        <br>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Last change</th>
            </tr>

            <tr v-for="s in g.groupmemberships" class="clickable-row" @click="openUser(s.user.id)">
                <td> {{s.id}} </td>
                <td> {{s.user.uid}} </td>
                <td> {{$moment(s.updated_at).format('H:ss - Do MMMM YYYY')}} </td>
            </tr>
            <tr v-if="!(g.groupmemberships.length > 0)"><td colspan="5">No users in the database.</td></tr>
        </table>
    </div>
</template>

<script>
    import {ADMIN_GROUPS_URL} from "../../../config";

    export default {
        name: "AdminGroup",
        data(){
            return {
                isLoading: true,
                g: { name:'',  groupmemberships:{}}
            }
        },
        async created(){
            this.isLoading = true;
            await axios({
                method:'get',
                url: ADMIN_GROUPS_URL + this.$route.params.id,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                this.g = response.data.data;
            });
            this.isLoading = false;
        },
        methods:{
            openUser(id){
                this.$router.push({ name: 'Admin User', params: { id: id } });
            }
        },
    }
</script>

<style scoped>

</style>