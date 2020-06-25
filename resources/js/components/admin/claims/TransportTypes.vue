<template>
    <div v-if="!isLoading">
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <hr>
        <h2>Transport Types</h2>
        <hr>
        <div class="well">
            This page shows all available transport types. At this time there is no requirement for any custom types.
        </div>
        <br>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
            </tr>
            <tr v-for="status in statuses">
                <td>{{status.id}}</td>
                <td>{{status.name}}</td>
            </tr>
            <tr v-if="!(statuses.length > 0)">
                <td colspan="2">There are no Transport Types in the database.</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../../config";

    export default {
        name: "TransportTypes",
        data(){
            return {
                isLoading: true,
                statuses: {},
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
                    method:'get',
                    url: API_BASE_URL + '/transporttype',
                }).then(response => {
                    this.statuses = response.data.data;
                }).catch(e => {
                    console.log(e);
                });
            },
        }
    }
</script>

<style scoped>

</style>