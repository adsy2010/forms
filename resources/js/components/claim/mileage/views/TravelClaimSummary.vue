<template>
    <div>
        <hr>
        <h2>Claim Summary - £{{ formatPrice(totalAmount) }}</h2>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px;">
                <MileageBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :mileage="claimData.mileage"
                        :editable="false"
                >
                </MileageBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <TransportBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :transport="claimData.transport"
                        :calculate-amount="calculateAmount"
                        :editable="false"
                >
                </TransportBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <ParkingBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :parking="claimData.parking"
                        :calculate-amount="calculateAmount"
                        :editable="false"
                >
                </ParkingBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <SubsistenceBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :subsistence="claimData.subsistence"
                        :calculate-amount="calculateAmount"
                        :editable="false"
                >
                </SubsistenceBox>
            </div>
        </div>
    </div>
</template>

<script>
    import { API_BASE_URL } from '../../../../config.js'
    import MileageBox from "../boxes/MileageBox";
    import TransportBox from "../boxes/TransportBox";
    import ParkingBox from "../boxes/ParkingBox";
    import SubsistenceBox from "../boxes/SubsistenceBox";
    export default {
        name: "TravelClaimSummary",
        description: "This page shows the boxes summarising the claims details only.",
        components:{
            MileageBox,
            TransportBox,
            ParkingBox,
            SubsistenceBox
        },
        props: ['claim'],
        data(){
            return {
                isLoading: true,
                claimData: {mileage:{},transport:{},subsistence:{},parking:{}},

                totalAmount:0
            }
        },
        created() {
            this.isLoading = true;
            this.loadClaim();
            this.isLoading = false;
        },
        methods: {

            // Should be able to remove all the calls into this one
            async loadClaim() {
                await axios({
                    method: 'get',
                    url: API_BASE_URL + '/claims/travel/a/' + this.$props.claim,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    console.log(response);
                    this.claimData = response.data.data.travelclaim;
                });
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2);
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            sizeOfObj(value) {
                return value.length;
            },
            calculateAmount(dataset)
            {
                let sum = 0;
                try {
                    dataset.forEach(e => {
                        sum += e.amount;
                    });
                }
                catch {}
                return sum;
            },
        }
    }
</script>

<style scoped>

</style>