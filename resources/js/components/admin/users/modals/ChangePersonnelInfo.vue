<template>
    <!-- Modal -->
    <div id="changePIModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>
                            Change {{currentUser.FirstName}}'s Personnel Details
                        </h3>
                    </div>
                    <div class="modal-body">
                        <v-text-field
                                placeholder="Personnel Number"
                        >
                        </v-text-field>
                        <v-text-field
                                placeholder="National Insurance Number"
                        >
                        </v-text-field>
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
    export default {
        name: "ChangePersonnelInfo",
        data(){
            return {
                valid: false,
            }
        }
    }
</script>

<style scoped>

</style>