<template>
    <div v-show="!isLoading">
        <!--
        <FORM1></FORM1>
        <FORM2></FORM2>
        <FORM3></FORM3>
        <FORM4></FORM4>-->
        <HoursClaimItem :id="this.$props.claim.id" :claim="this.$props.claim.id" v-if="this.formName.toLowerCase().includes('time claim')"></HoursClaimItem>
        <TravelClaimSummary :id="this.$props.claim.id" :claim="this.$props.claim.id" v-if="this.formName.toLowerCase().includes('travel')"></TravelClaimSummary>
    </div>
</template>

<script>
    import HoursClaimItem from "../time/views/HoursClaimItem";
    import TravelClaimItemComponent from "../mileage/views/TravelClaimItemComponent";
    import TravelClaimSummary from "../mileage/views/TravelClaimSummary";
    export default {
        name: "Reviewable",
        components: {TravelClaimSummary, HoursClaimItem,TravelClaimItemComponent},
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