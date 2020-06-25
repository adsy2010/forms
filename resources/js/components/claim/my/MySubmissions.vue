<template>
    <div>
        <Breadcrumbs></Breadcrumbs>
        <hr>
        <h2>Submissions</h2>
        <hr>
        <hr>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Form</th>
                <th>Period</th>
                <th>Status</th>
                <th>Created</th>
                <th>Options</th>
            </tr>
            <tr v-for="submission in submissions" v-if="submissions.length > 0">
                <td style="vertical-align: middle;">{{ submission.id }}</td>
                <td style="vertical-align: middle;">{{ submission.claim_data.claim_form.name }}</td>
                <td style="vertical-align: middle;">{{ $moment(submission.claim_data.period, "YYYYMM").format("MMMM YYYY") }}</td>
                <td style="vertical-align: middle;">{{ submission.claim_data.claim_status.state }}</td>
                <td style="vertical-align: middle;">{{ $moment(submission.created_at).format("H:mm L") }}</td>
                <td>
                    <v-btn color="error" v-if="submission.claim_data.claim_status.state.includes('Submitted')">Retract</v-btn>
                    <p v-else> No options available</p>
                </td>
            </tr>
            <tr v-if="!(submissions.length > 0)">
                <td colspan="6">No entries</td>
            </tr>


        </table>
    </div>
</template>

<script>
    import {API_BASE_URL, CLAIMS_ROOT_URL} from "../../../config";

    export default {
        name: "MySubmissions",
        data(){
            return {
                isLoading: true,
                submissions: {}
            }
        },
        created() {
            this.isLoading = true;
            this.read();
            this.isLoading = false;
        },
        methods:{
            async read()
            {
                await axios({
                    method: 'get',
                    url: API_BASE_URL + CLAIMS_ROOT_URL + 'submissions',
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    this.submissions = response.data.data;
                });
            },
            async retract(id)
            {
                await axios({
                    method: 'delete',
                    url: API_BASE_URL + CLAIMS_ROOT_URL + 'submissions/' + id,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    this.read();
                });
            }
        }
    }
</script>