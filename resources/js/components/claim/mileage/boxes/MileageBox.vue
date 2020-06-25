<template>
    <div class="card">
        <div class="card-heading bg-primary p-2"><span class="fa fa-road"></span> Mileage</div>
        <div class="card-body">
            <table class="table" style="border-top:0;">
                <tr>
                    <th>Date</th>
                    <th class="d-none d-md-block" style="min-width: 225px; max-width: 225px;">From</th>
                    <th style="min-width: 225px; max-width: 225px;">To</th>
                    <th>Mileage</th>
                    <th>Total</th>
                    <th style="min-width: 70px;"></th>
                </tr>
                <template @delete="delMileage" :formatPrice="formatPrice" v-for="m in mileage"  v-if="sizeOfObj(mileage) > 0">
                    <tr v-bind:key="m.id">
                        <td>{{ $moment(m.mileageDate).format("L") }}</td>
                        <td class="d-none d-md-block">{{ m.origin }}</td>
                        <td>{{ m.destination }}</td>
                        <td>{{ m.mileage }}</td>
                        <td>£{{ formatPrice(m.amount) }}</td>
                        <td class="text-right">
                            <span class="text-primary fa fa-pencil" data-toggle="modal" data-target="#mileageModal" @click="update(m.id)" v-if="editable"></span>&nbsp;&nbsp;
                            <span class="text-danger fa fa-trash" @click="del(m.id)" v-if="editable"></span>
                        </td>
                    </tr>
                </template>
                <template v-if="sizeOfObj(mileage) === 0">
                    <tr><td colspan="6">No items</td></tr>
                </template>
            </table></div>
        <div class="card-footer">Total: £{{ formatPrice(0) }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            'mileage':{},
            'formatPrice':{},
            'sizeOfObj':{},
            'calculateAmount':{},
            'editable':{default: true,type: Boolean}

        },
        name: "MileageBox",
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

        },
        watch: {

        }
    }
</script>

<style scoped>

</style>