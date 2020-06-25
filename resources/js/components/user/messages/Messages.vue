<template>
    <div>
        <Breadcrumbs></Breadcrumbs>
        <h2>{{this.$route.name}}</h2>
        <hr>
        <div class="well">
            User information
        </div>

        <br>
        <br>
        <table class="table table-hover">
            <tr>
                <th style="width:50px;">Status</th>
                <th>#</th>
                <th>Subject</th>
                <th>Sent</th>
            </tr>
            <tr v-if="messages.length <=0"><td colspan="5">No messages in the database.</td></tr>
            <tr v-for="message in messages"
                v-bind:class="[(message.read > 0)?'':'unread','clickable-row']"
                @click="openMessage(message.id)">
                <td class="text-center">
                    <span v-bind:class="[(message.read > 0)?'fa-envelope-open':'fa-envelope', 'fa']"></span>
                </td>
                <td> {{ message.id }} </td>
                <td> {{ message.subject }} </td>
                <td> {{ message.created_at }} </td>
            </tr>
        </table>

        </div>
</template>

<script>
    import {MESSAGES_URL} from "../../../config";

    export default {
        name: "Messages",
        props: ['token'],
        data(){
            return {
                'isLoading': true,
                'messages': {}
            }
        },
        async created(){
            this.isLoading = true;
            await axios({
                method:'get',
                url: MESSAGES_URL,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                console.log(response.data.data);
                this.messages = response.data.data.messages.data;
            });
            this.isLoading = false;

        },
        methods:{
            openMessage(id){
                this.$router.push({ name: 'Message', params: { id: id } });
            }
        }
    }
</script>

<style scoped>

</style>