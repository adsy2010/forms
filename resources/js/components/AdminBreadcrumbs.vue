<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link :to="{name:'Admin Dashboard'}">Dashboard</router-link></li>
            <li v-for="p in parents" class="breadcrumb-item">
                <router-link :to="{name:p}">{{ p }}</router-link>
            </li>
            <li class="breadcrumb-item">{{ this.$route.name }}</li>
        </ol>
    </nav>
</template>

<script>
    export default {
        name: "AdminBreadCrumbs",
        props:['parents'],
        created() {
        },
    }
</script>
