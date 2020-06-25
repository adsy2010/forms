<template>
    <div v-if="!isLoading">
        <AdminBreadcrumbs></AdminBreadcrumbs>
        <hr>
        <h2>Mileage PPM</h2>
        <hr>
        <div class="well">
            This page shows all available PPM's.
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;">
                <a class='btn btn-primary' data-toggle="modal" data-target="#mileagetypePPMModal" style="padding:25px; min-width: 300px; font-size:36px;">Add PPM</a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Effective from</th>
                <th>PPM</th>
                <th>Options</th>
            </tr>
            <tr v-for="ppm in ppms">
                <td>{{ppm.id}}</td>
                <td>{{ppm.m_type.name}}</td>
                <td>{{$moment(ppm.effectivePeriod, 'YYYYMM').format('L')}}</td>
                <td><v-text-field v-model="ppm.amount" :disabled="inThePast(ppm.effectivePeriod)"></v-text-field></td>
                <td>
                    <v-btn small color="primary" :disabled="inThePast(ppm.effectivePeriod)" @click="update(ppm.id, ppm.mileageType, ppm.effectivePeriod, ppm.amount)">update</v-btn>
                    <v-btn small color="red" style="color:white;" :disabled="inThePast(ppm.effectivePeriod)" @click="del(ppm.id)"><span class="fa fa-trash"></span></v-btn>
                </td>
            </tr>
            <tr v-if="!(ppms.length > 0)">
                <td colspan="2">There are no PPM's in the database.</td>
            </tr>
        </table>
        <AddPPM @refresh="retrieve"></AddPPM>
    </div>
</template>

<script>
    import {ADMIN_URL, API_BASE_URL} from "../../../config";
    import AddPPM from "./modals/AddPPM";

    export default {
        name: "MileagePPM",
        components: {AddPPM},
        data(){
            return {
                isLoading: true,
                ppms: {},
            }
        },
        async created(){
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
            async retrieve(){
                await axios({
                    method:'get',
                    url: ADMIN_URL + 'mileagetypes/ppm',
                    params:{remember_token:this.$root.getToken()}
                }).then(response => {
                    this.ppms = response.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },
            inThePast(evaluate){
                return (evaluate <= this.$moment().format('YYYYMM'));
            },
            async update(id, mileageType, period, amount){
                let dataWrapper = {
                    mileageType: mileageType,
                    effectivePeriod: period,
                    amount: amount
                };
                await axios({
                    method:'put',
                    url: ADMIN_URL + 'mileagetypes/ppm/'+id,
                    data:dataWrapper,
                    params:{remember_token:this.$root.getToken()}
                }).then(response => {
                    console.log(response);
                }).catch(err =>{
                    console.log(err);
                });
                await this.retrieve();
            },
            async del(id){
                await axios({
                    method:'delete',
                    url: ADMIN_URL + 'mileagetypes/ppm/'+id,
                    params:{remember_token:this.$root.getToken()}
                }).then(response => {
                    console.log(response);
                }).catch(err =>{
                    console.log(err);
                });
                await this.retrieve();
            }
        },
        computed:{

        }
    }
</script>

<style scoped>

</style>