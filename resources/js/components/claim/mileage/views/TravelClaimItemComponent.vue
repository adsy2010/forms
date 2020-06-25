<template>
    <div v-if="!isLoading">
        <Breadcrumbs v-bind:parents="['My Claims']"></Breadcrumbs>
    <hr>
    <h2>Add to claim</h2>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="#" @click="editMileage(0)" class="btn bg-primary" data-toggle="modal" data-target="#mileageModal" style="padding:25px; min-width: 300px; font-size:36px;"><span class="fa fa-road"></span> Mileage</a></div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="#" @click="editTransport(0)" class="btn bg-primary" data-toggle="modal" data-target="#transportModal" style="padding:25px; min-width: 300px; font-size:36px;"><span class="fa fa-plane"></span> Transport</a></div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="#" @click="editParking(0)" class="btn bg-primary" data-toggle="modal" data-target="#parkingModal" style="padding:25px; min-width: 300px; font-size:36px;"><span class="fa fa-gbp"></span> Parking</a></div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="#" @click="editSubsistence(0)" class="btn bg-primary" data-toggle="modal" data-target="#subsistenceModal" style="padding:25px; min-width: 300px; font-size:36px;"><span class="fa fa-apple"></span> Subsistence</a></div>
        </div>
        <hr>
        <h2>Claim Summary - £{{ formatPrice(totalAmount) }}</h2>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px;">
                <MileageBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :mileage="claim.mileage"
                        @update="editMileage"
                        @del="delMileage">
                </MileageBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <TransportBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :transport="claim.transport"
                        :calculate-amount="calculateAmount"
                        @update="editTransport"
                        @del="delTransport">
                </TransportBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <ParkingBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :parking="claim.parking"
                        :calculate-amount="calculateAmount"
                        @update="editParking"
                        @del="delParking">
                </ParkingBox>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;">
                <SubsistenceBox
                        :size-of-obj="sizeOfObj"
                        :formatPrice="formatPrice"
                        :subsistence="claim.subsistence"
                        :calculate-amount="calculateAmount"
                        @update="editSubsistence"
                        @del="delSubsistence">
                </SubsistenceBox>
            </div>
        </div>
        <mileage-modal
                :mileage="claim.mileage"
                :mileageItem="mileageItem"
        ></mileage-modal>
        <parking-modal
                :parking="claim.parking"
                :parkingItem="parkingItem"
        ></parking-modal>
        <subsistence-modal
                :subsistence="claim.subsistence"
                :subsistenceItem="subsistenceItem"
        ></subsistence-modal>
        <transport-modal
                :transport="claim.transport"
                :transportItem="transportItem"
        ></transport-modal>
    </div>
</template>

<script>
    import { API_BASE_URL } from '../../../../config.js'
    import MileageBox from "../boxes/MileageBox";
    import TransportBox from "../boxes/TransportBox";
    import ParkingBox from "../boxes/ParkingBox";
    import SubsistenceBox from "../boxes/SubsistenceBox";
    import TransportModal from "../modals/TransportModal";
    import SubsistenceModal from "../modals/SubsistenceModal";
    import ParkingModal from "../modals/ParkingModal";
    import MileageModal from "../modals/MileageModal";
    export default {
        name: "TravelClaimItemComponent",
        description: "This page is the fully interactive summary page to add items to the travel claim.",
        data()
        {

            return  {
                isLoading: true,
                claim: {mileage:{},transport:{},subsistence:{},parking:{}},
                /*mileage: {},
                transport: {},
                subsistence: {},
                parking: {},*/
                total: [],

                parkingAmount: 0,
                subsistenceAmount: 0,
                transportAmount: 0,

                //for editing purposes
                mileageItem: 0,
                parkingItem: 0,
                transportItem: 0,
                subsistenceItem: 0,

                ppm: 0.55,

            }
        },
        async created()
        {
            try {
                this.isLoading = true;
                if(typeof this.$route.params.id === 'undefined') this.$router.push({name:'My Claims'})
                await this.loadClaim();
                this.isLoading = false;
            }
            catch (e) {
                console.log(e);
            }
        },
        methods: {

            // Should be able to remove all the calls into this one
            async loadClaim()
            {
                await axios({
                    method:'get',
                    url: API_BASE_URL + '/claims/travel/'+this.$route.params.id,
                    params: {remember_token: this.$root.getToken()}
                }).then(response =>{
                    //console.log(response);
                    this.claim = response.data.data.travelclaim;
                });
            },
            async delTransport(id) {
                axios.delete(API_BASE_URL+'/claims/travel/transport/'+id)
                    .then(response => {
                        let index = this.transport.findIndex(transport => transport.id === id);
                        this.transport.splice(index, 1);
                        this.$forceUpdate();
                        this.total.find(total => total.name === "transport").amount = this.transportAmount;
                        //let totalIndex = this.total.find(total => total.name === "transport").amount = this.transportAmount();
                    })
                    .catch(error => {

                    })
            },
            async delMileage(id) {
                axios.delete(API_BASE_URL+'/claims/travel/mileage/'+id)
                    .then(response => {
                        let index = this.mileage.findIndex(mileage => mileage.id === id);
                        this.mileage.splice(index, 1);
                        this.$forceUpdate();
                        this.total.find(total => total.name === "mileage").amount = this.mileageAmount;
                        //let totalIndex = this.total.find(total => total.name === "transport").amount = this.transportAmount();
                    })
                    .catch(error => {

                    })
            },
            async delSubsistence(id) {
                axios.delete(API_BASE_URL+'/claims/travel/subsistence/'+id)
                    .then(response => {
                        let index = this.subsistence.findIndex(subsistence => subsistence.id === id);
                        this.subsistence.splice(index, 1);
                        this.$forceUpdate();
                        this.total.find(total => total.name === "subsistence").amount = this.subsistenceAmount;
                        //let totalIndex = this.total.find(total => total.name === "transport").amount = this.transportAmount();
                    })
                    .catch(error => {

                    })
            },
            async delParking(id) {
                axios.delete(API_BASE_URL+'/claims/travel/parking/'+id)
                    .then(response => {
                        let index = this.parking.findIndex(parking => parking.id === id);
                        this.parking.splice(index, 1);
                        this.$forceUpdate();
                        this.total.find(total => total.name === "parking").amount = this.parkingAmount;
                        //let totalIndex = this.total.find(total => total.name === "transport").amount = this.transportAmount();
                    })
                    .catch(error => {

                    })
            },
            editTransport(id){
                this.transportItem = id;
            },
            editMileage(id){
                this.mileageItem = id;
            },
            editSubsistence(id){
                this.subsistenceItem = id;
            },
            editParking(id){
                this.parkingItem = id;
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
            calculateMileage() {
                this.mileage.forEach(e => {
                    e.amount = e.mileage * this.ppm;
                });
            },
            reset () {
                this.$refs.form.reset()
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },
        computed: {
            totalAmount: function() {
                return this.calculateAmount(this.total);
            },

            /*transportAmount: function () {
                if(this.isLoading === true) return 0;
                return this.total.find(total => total.name === "transport").amount = (this.isLoading === false) ? this.calculateAmount(this.transport) : 0;
            },*/
            mileageAmount: function () {
                if(this.isLoading === true) return 0;
                return this.total.find(total => total.name === "mileage").amount = (this.isLoading === false) ? this.calculateAmount(this.mileage) : 0;
            },
            /*parkingAmount: function () {
                if(this.isLoading === true) return 0;
                return this.total.find(total => total.name === "parking").amount = (this.isLoading === false) ? this.calculateAmount(this.parking) : 0;
            },
            subsistenceAmount: function () {
                if(this.isLoading === true) return 0;
                return this.total.find(total => total.name === "subsistence").amount = (this.isLoading === false) ? this.calculateAmount(this.subsistence) : 0;
            }*/

        },
        watch: {
        },
        components:{
            MileageModal,
            ParkingModal,
            SubsistenceModal,
            TransportModal,
            MileageBox,
            TransportBox,
            ParkingBox,
            SubsistenceBox
        }

    }
</script>

<style scoped>

</style>