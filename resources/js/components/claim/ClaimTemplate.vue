<template>
    <div v-show="!isLoading">
        <!--
        <FORM1></FORM1>
        <FORM2></FORM2>
        <FORM3></FORM3>
        <FORM4></FORM4>-->
        <HoursClaimItem :claim="this.$props.claim.id" v-if="this.formName.toLowerCase().includes('time claim')"></HoursClaimItem>
        <TravelClaimItemComponent :claim="this.$props.claim.id" v-if="this.formName.toLowerCase().includes('travel')"></TravelClaimItemComponent>
    </div>
</template>

<script>
    import HoursClaimItem from "./time/views/HoursClaimItem";
    import TravelClaimItemComponent from "./mileage/views/TravelClaimItemComponent";
    export default {
        name: "ClaimTemplate",
        components: {HoursClaimItem,TravelClaimItemComponent},
        props: ['form', 'claim'],
        data(){
            return {
                isLoading: true,
                formName: '',
            }
        },
        created(){
            this.isLoading = true;

            this.isLoading = false;
        },
        methods:{
            async retrieve(){
                try{
                    await axios({
                        method: 'get',
                        url: '',
                        params: {remember_token:this.$root.getToken()}
                    }).then(response => {

                    });
                }
                catch (e) {

                }
            }
        },
        watch:{
            '$props.claim': function(){
                this.formName = this.$props.claim.claim_form.name;
            }
        }
    }
</script>

<style scoped>

</style>