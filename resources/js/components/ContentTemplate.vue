<template>
    <div class="container">
        <div class="card card-default">

            <div class="card-heading p-2 heading-style">{{ headingTitle }}</div>
            <div class="card-body">
                <transition name="fade" mode="out-in">
                    <router-view @setTitle="setTitle"/>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContentTemplate",
        created() {
            this.$root.setToken(this.$parent.$attrs.token);
        },
        data(){
            return{
                'headingTitle': 'Dashboard'
            }
        },
        methods:{
            setTitle(title){
                this.headingTitle = title;
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition-duration: 0.3s;
        transition-property: opacity;
        transition-timing-function: ease;
    }

    .fade-enter,
    .fade-leave-active {
        opacity: 0
    }
</style>