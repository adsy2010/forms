<template>
    <div class="card ">
        <div class="card-heading bg-primary p-2"><span class="fa fa-apple"></span> Subsistence</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                    <th style="width:70px;"></th>
                </tr>
                <template @delete="delSubsistence" :formatPrice="formatPrice" v-for="s in subsistence"  v-if="sizeOfObj(subsistence) > 0">
                    <tr v-bind:key="s.id">
                        <td>{{ $moment(s.subsistenceDate).format('L') }}</td>
                        <td>£{{ formatPrice(s.amount) }}</td>
                        <td class="text-right">
                            <span class="text-primary fa fa-pencil" data-toggle="modal" data-target="#subsistenceModal" @click="update(s.id)" v-if="editable"></span>&nbsp;&nbsp;
                            <span class="text-danger fa fa-trash" @click="del(s.id)" v-if="editable"></span>
                        </td>
                    </tr>
                </template>
                <template v-if="sizeOfObj(subsistence) === 0">
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
            'subsistence':{},
            'formatPrice':{},
            'sizeOfObj':{},
            'calculateAmount':{},
            'editable':{default: true,type: Boolean}

        },
        name: "SubsistenceBox",
        methods: {
            //place callback functions here
            del(id){
                this.$emit('delete', id); //need to add the ID
            },
            update(id){
                this.$emit('update', id); //need to add the ID
            },
        },
        computed: {
            amount: function(){
                return this.calculateAmount(this.subsistence);
            }
        },
        watch: {

        }
    }
</script>