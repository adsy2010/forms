<template>
    <div v-if="!isLoading">
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <hr>
        <h2>Claim Statuses</h2>
        <hr>
        <div class="well">
            This page shows all available claim statuses. At this time there is no requirement for any custom statuses.
        </div>
        <br>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Status</th>
            </tr>
            <tr v-for="status in statuses">
                <td>{{status.id}}</td>
                <td>{{status.state}}</td>
            </tr>
            <tr v-if="!(statuses.length > 0)">
                <td colspan="2">There are no claim statuses in the database.</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {API_BASE_URL} from "../../../config";

    export default {
        name: "ClaimStatuses",
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
                    url: API_BASE_URL + '/claimstatus',
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