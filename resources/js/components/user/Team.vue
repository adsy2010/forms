<template>
    <div>
        <Breadcrumbs></Breadcrumbs>
        <div class="well">
            Your team below are line managed by you.
        </div>

        <table class="table">
            <tr>
                <th>#</th>
                <th>UID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th></th>
            </tr>
            <tr v-if="!isLoading" v-for="member in team">
                <td> {{ member.user.id }} </td>
                <td> {{ member.user.uid }} </td>
                <td> {{ member.user.FirstName }} </td>
                <td> {{ member.user.LastName }} </td>
                <td> {{ member.user.staffdetails.position }} </td>
                <td><div data-toggle="modal" data-target="#flagModal" class=""><span class="text-danger fa fa-flag" title="Flag this person"></span></div></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {MY_TEAM_URL} from "../../config";

    export default {
        name: "Team",
        data()
        {
            return {
                isLoading: true,
                team: {
                }
            }

        },
        async created(){
            this.isLoading = true;
            await axios({
                method: 'get',
                url: MY_TEAM_URL,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                this.team = response.data.data.team;
            });
            this.isLoading = false;
        }
    }
</script>