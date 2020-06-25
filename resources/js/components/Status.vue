<template>
    <div>
        <div v-if="status.status.length > 0" :class="[
                'alert',
                (status.status.startsWith('20')) ? 'alert-success' : '',
                (status.status.startsWith('w')) ? 'alert-warning' : '',
                (status.status.startsWith('4')) ? 'alert-danger' : ''
            ]">
            <button class="close" @click="closeMessage">x</button>
            <strong v-if="status.status.startsWith('20')">Success!</strong>
            <strong v-if="status.status.startsWith('w')">Warning!</strong>
            <strong v-if="status.status.startsWith('4')">Whoops! Something went wrong!</strong>
            ::: {{ status.message }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Status",
        props:['status'],
        methods:
        {
            closeMessage(){
                this.$emit('clicked');
            }
        }
    }
</script>