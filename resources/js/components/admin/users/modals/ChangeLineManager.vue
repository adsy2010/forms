<template>
    <!-- Modal -->
    <div id="changeLMModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Change {{currentUser.FirstName}}'s Line Manager</h3>
                    </div>
                    <div class="modal-body">
                        Current line manager:
                        <span v-if="!(currentUser.linemanager == null)">
                            <strong>
                                {{currentUser.linemanager.manager.FirstName}}
                                {{currentUser.linemanager.manager.LastName}}
                            </strong>
                        </span>
                        <span v-else>No line manager currently</span>
                        <v-autocomplete
                            placeholder="Select a new line manager"
                            v-model="linemanagers.id"
                            :items="linemanagers"
                            :item-text="item => item.LastName +', '+ item.FirstName"
                            item-value="id"
                        >

                        </v-autocomplete>
                    </div>
                    <div class="modal-footer">
                        <v-btn
                                :disabled="!valid"
                                class="mr-4 btn btn-primary"
                        >
                            Update
                        </v-btn>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </v-form>
    </div>
</template>

<script>
    import {ADMIN_URL} from "../../../../config";

    export default {
        name: "ChangeLineManager",
        props:['currentUser'],
        data(){
            return {
                valid:false,
                isLoading:true,
                linemanagers:[{users:{FirstName:'',LastName:''}}],
            }
        },
        async created() {
            this.isLoading = false;
            await this.retrieve();
            this.isLoading = true;
        },
        methods:{
            async retrieve()
            {
                await axios({
                    method:'get',
                    url:ADMIN_URL+'stafflist',
                    params:{remember_token:this.$root.getToken()}
                }).then(response => {
                    this.linemanagers = response.data.data[0].users;
                });
            }
        },
        computed:{
            filteredLineManagers(){
                return this.linemanagers;
            }
        }
    }
</script>

<style scoped>

</style>