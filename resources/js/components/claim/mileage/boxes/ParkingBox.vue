<template>
    <div class="card">
        <div class="card-heading bg-primary p-2"><span class="fa fa-gbp"></span> Parking</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                    <th style="width:70px;"></th>
                </tr>
                <template @delete="delParking" :formatPrice="formatPrice" v-for="p in parking"  v-if="sizeOfObj(parking) > 0">
                    <tr v-bind:key="p.id">
                        <td>{{ $moment(p.parkingDate).format('L') }}</td>
                        <td>£{{ formatPrice(p.amount) }}</td>
                        <td class="text-right">
                            <span class="text-primary fa fa-pencil" data-toggle="modal" data-target="#parkingModal" @click="update(p.id)" v-if="editable"></span>&nbsp;&nbsp;
                            <span class="text-danger fa fa-trash" @click="del(p.id)" v-if="editable"></span>
                        </td>
                    </tr>
                </template>
                <template v-if="sizeOfObj(parking) === 0">
                    <tr><td colspan="3">No items</td></tr>
                </template>
            </table>
        </div>
        <div class="card-footer">Total: £{{ formatPrice(amount) }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            'parking':{},
            'formatPrice':{},
            'sizeOfObj':{},
            'calculateAmount':{},
            'editable':{default: true,type: Boolean}

        },
        name: "ParkingBox",
        methods: {
            //place callback functions here
            del(id){
                this.$emit('delete', id); //need to add the ID
            },
            update(id){
                this.$emit('update', id); //need to add the ID
            }
        },
        computed: {
            amount: function(){
                return this.calculateAmount(this.parking);
            }
        },
        watch: {

        }
    }
</script>