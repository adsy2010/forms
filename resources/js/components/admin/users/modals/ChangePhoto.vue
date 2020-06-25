<template>
    <!-- Modal -->
    <div id="changePhotoModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Change {{currentUser.FirstName}}'s Photo</h3>
                    </div>
                    <div class="modal-body">
                        <div id="photos" class="mx-auto d-block text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="rounded-circle" style="max-height:150px;" :src="photoAvailable ? '/files/images/staff/'+currentUser.uid+'.jpg' : '/images/staff/placeholder.png'" alt="...">
                                    <p>Current Photo</p>
                                </div>
                                <div class="col-md-6">
                                    <img class="rounded-circle" style="max-height:150px;" :src="newPhoto ? '/files/images/staff/'+currentUser.uid+'.jpg' : '/images/staff/placeholder.png'" alt="...">
                                    <p>Replacement Photo</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <v-file-input
                                placeholder="Upload a replacement photo"
                                show-size
                                filled
                                prepend-icon="mdi-camera"
                            >
                            </v-file-input>
                            <v-btn class="text-center" color="primary">Upload File</v-btn>
                        </div>

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
        name: "ChangePhoto",
        props: ['photoAvailable','currentUser'],
        data(){
            return {
                newPhoto: false,
                valid: false,
            }
        }
    }
</script>

<style scoped>

</style>