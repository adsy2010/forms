<template>
    <div id="AuthFormGroupModal" class="modal fade" role="dialog">
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add a group</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"/>
                        <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <v-autocomplete
                                label="Select a group"
                                v-model="groupId"
                                item-text="name"
                                item-value="id"
                                :rules="groupRules"
                                :items="groups">

                        </v-autocomplete>
                        <v-radio-group v-model="pattern" label="Authorisation group pattern"
                                       :rules="patternRules">
                            <v-radio label="One group member" :value="0"></v-radio>
                            <v-radio label="All group members" :value="1"></v-radio>
                        </v-radio-group>

                    </div>
                    <div class="modal-footer">
                        <v-btn color="primary" data-dismiss="modal" @click="validate" :disabled="!valid">Add to form</v-btn>
                        <v-btn color="warning" data-dismiss="modal">Cancel</v-btn>
                    </div>
                </div>
            </div>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "AuthFormGroup",
        props: ['formId', 'priority', 'groups'],
        data(){
            return {
                valid: false,
                pattern: -1,
                groupId: -1,

                patternRules: [v => v  >= 0 || 'Please select either all members or one member',],
                groupRules: [v => (!isNaN(parseFloat(v)) && v >= 0 && v <= 999)  || 'Please select a group',],
            }
        },
        methods: {
            addGroup()
            {
                this.$emit('add', { groupData: {
                        formId: this.formId,
                        priority: this.priority,
                        groupId: this.groupId,
                        pattern: this.pattern,
                    }
                });
                this.$refs.form.reset();
            },
            validate(){
                if(this.$refs.form.validate())
                   this.addGroup();
            }
        }
    }
</script>