<template>
    <div>
        <AdminBreadcrumbs></AdminBreadcrumbs>
        display the auth form groups by form
        <div v-for="form in forms" v-if="forms.length > 0">
            <hr>
            <div class="card">
                <div class="card-header heading-style">
                    <div class="row">
                    <div class="col-md-6"><h4 class="">{{ form.name }}</h4></div>
                    <div class="col-md-6"><v-btn class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#AuthFormGroupModal" @click="setNextData(form.id, form.auth_groups.length + 1)">Assign group</v-btn></div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Group</th>
                            <th>Priority</th>
                            <th>Pattern</th>
                            <th>Options</th>
                        </tr>
                        <tr v-for="group in form.auth_groups">
                            <td>{{group.group_data.name}}</td>
                            <td>{{group.priority}}</td>
                            <td>{{(group.pattern > 0) ? 'All': 'One'}}</td>
                            <td><v-btn color="red" @click="del(group.id)"><span class="fa fa-trash"></span></v-btn></td>
                        </tr>
                        <tr v-if="!(form.auth_groups.length > 0)"><td colspan="3">No groups are assigned to this form.</td></tr>
                    </table>
                    <div v-if="!(forms.length > 0)">
                        <p class="lead">There are no forms in the database.</p>
                    </div>
                </div>
            </div>
        </div>
        <AuthFormGroup @add="addGroup" :groups="groups" :form-id="currentForm" :priority="currentFormPriority"></AuthFormGroup>
    </div>
</template>

<script>
    import {ADMIN_GROUPS_URL, ADMIN_URL, API_BASE_URL} from "../../../config";
    import AuthFormGroup from "./AuthFormGroup";

    export default {
        name: "AuthFormGroups",
        components: {AuthFormGroup},
        data(){
            return {
                isLoading: true,
                groups: [],
                currentForm: 0,
                currentFormPriority: 0,
                forms: { auth_groups: {} },
            }
        },
        created(){
            this.isLoading = true;
            this.retrieve();
            this.pullGroups();
            this.isLoading = false;
        },
        methods:{
            async retrieve()
            {
                try{
                    await axios({
                        method: 'get',
                        url: API_BASE_URL + '/form/',
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        this.forms = response.data.data;
                    });
                }
                catch (e) {
                    
                }
            },
            pullGroups()
            {
                try{
                    axios({
                        method: 'get',
                        url: ADMIN_GROUPS_URL,
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        this.groups = response.data.data;
                    });
                }
                catch (e) {

                }
            },
            async addGroup(groupData){
                this.save(groupData);
            },
            save(groupData){
                axios({
                    method: 'post',
                    url: ADMIN_URL + 'agf-members',
                    params: {remember_token: this.$root.getToken()},
                    data: groupData
                }).then(response => {
                    if(response.status === 200) {
                        this.retrieve();
                        this.currentFormPriority += 1;
                    }
                })

            },
            setNextData(id, priority)
            {
                this.currentForm = id;
                this.currentFormPriority = priority;
            },
            del(id){
                axios({
                    method: 'delete',
                    url: ADMIN_URL + 'agf-members/' + id,
                    params: {remember_token: this.$root.getToken()},
                }).then(response => {
                    if(response.status === 200){
                        console.log(response);
                        this.retrieve();
                    }
                });

            },
            swap(first, second)
            {
                console.log(first.priority, second.priority);
                let swapFrom = first.priority;
                first.priority = second.priority;
                second.priority = swapFrom;
                console.log(first.priority, second.priority);
                /*
                axios({
                    method: 'put',
                    url: '',
                    params: {remember_token: this.$root.getToken()},
                    data: {first, second}
                }).then(response => {

                });*/
            }
        }
    }
</script>