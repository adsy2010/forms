<template>
    <div>
        <Breadcrumbs v-bind:parents="['Messages']"></Breadcrumbs>
        <h2>{{this.$route.name}}</h2>
        <hr>
        <div class="well p-4">
            {{ message.message }}
        </div>

        <div class="card-footer">
            Sent at {{$moment(message.created_at, "YYYY-MM-DD H:m:ss").format('H:m \on Do MMMM YYYY')}}
        </div>
    </div>
</template>

<script>
    import {MESSAGES_URL} from "../../../config";

    export default {
        name: "MessageDetails",
        data(){
            return {
                'message':'',
            }
        },
        async created(){
            this.isLoading = true;
            let url = MESSAGES_URL + this.$route.params.id;
            await axios({
                method:'get',
                url: url,
                params: {remember_token: this.$root.getToken()}
            }).then(response => {
                this.message = response.data.data.message;
            });
            this.isLoading = false;

        },
    }
</script>
