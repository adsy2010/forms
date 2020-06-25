<template>
    <div class="card ">
        <div class="card-heading bg-primary p-2"><span class="fa fa-plane"></span> Transport</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th style="width:70px;"></th>
                </tr>
                <template @delete="delTransport" :formatPrice="formatPrice" v-for="t in transport"  v-if="sizeOfObj(transport) > 0">
                    <tr v-bind:key="t.id">
                        <td>{{ $moment(t.transportDate).format('L') }}</td>
                        <td>{{ t.transport_type_name.name }}</td>
                        <td>£{{ formatPrice(t.amount) }}</td>
                        <td class="text-right">
                            <span class="text-primary fa fa-pencil" data-toggle="modal" data-target="#transportModal" @click="update(t.id)" v-if="editable"></span>&nbsp;&nbsp;
                            <span class="text-danger fa fa-trash" @click="del(t.id)" v-if="editable"></span>
                        </td>
                    </tr>
                </template>
                <template v-if="sizeOfObj(transport) === 0">
                    <tr><td colspan="4">No items</td></tr>
                </template>

            </table>
        </div>
        <div class="card-footer">Total: £{{ formatPrice(amount) }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            'transport':{},
            'formatPrice':{},
            'sizeOfObj':{},
            'calculateAmount':{},
            'editable':{default: true,type: Boolean}
        },
        name: "TransportBox",
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
            amount: function () {
                return this.calculateAmount(this.transport)
            }
        },
        watch: {

        }
    }
</script>

<style scoped>

</style>