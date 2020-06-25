<template>
    <div>
        <div class="well">
            Admin Dashboard
        </div>
        <br>
        <template>
            <h2>User Management</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{ name: 'Admin Users' }" class="btn bg-info btn-nav-custom"><span class="fa fa-users"></span> Users</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{ name: 'Admin Sessions' }" class="btn bg-info btn-nav-custom"><span class="fa fa-user-tag"></span> User Sessions</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{ name: 'Admin Groups' }" class="btn bg-info btn-nav-custom"><span class="fa fa-layer-group"></span> AD Groups</router-link></div>
            </div>
        </template>


        <template>
            <h2>Human Resources</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link to="/" class="btn bg-danger btn-nav-custom"><span class="glyphicon glyphicon-credit-card"></span> HR Details</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link to="/" class="btn bg-danger btn-nav-custom"><span class="glyphicon glyphicon-road"></span> Travel Claims</router-link></div>
            </div>
        </template>

        <template>
            <h2>Services</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link to="/" class="btn bg-success btn-nav-custom"><span class="glyphicon glyphicon-phone-alt"></span> Helpdesk</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link to="/" class="btn bg-success btn-nav-custom"><span class="glyphicon glyphicon-globe"></span> Absences</router-link></div>

            </div>
        </template>

        <template>
            <h2>Claims settings</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{name: 'Admin Mileage Types'}"       class="btn bg-warning btn-nav-custom"><span class="fa fa-road"></span> Mileage Types</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{name: 'Admin Mileage PPM'}"         class="btn bg-warning btn-nav-custom"><span class="fa fa-gbp"></span> Mileage PPM</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{name: 'Admin Transport Types'}"     class="btn bg-warning btn-nav-custom"><span class="fa fa-bus"></span> Transport Types</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{name: 'Admin Claim Statuses'}"      class="btn bg-warning btn-nav-custom"><span class="fa fa-clipboard-list"></span> Claim Statuses</router-link></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center btn-bottom-margin" ><router-link :to="{name: 'Admin AuthGroup Members'}"   class="btn bg-warning btn-nav-custom"><span class="fa fa-group"></span> Authoriser Groups</router-link></div>

            </div>
        </template>

    </div>
</template>

<script>
    export default {
        name: "AdminDashboard",
        data(){
            return {
                authorised: false,
            }
        },
        created() {
            this.authorised = false;
            this.checkAuthorised();
        },
        methods: {
            async checkAuthorised(){
                /*
                try {
                    await axios({
                        method: 'get',
                        url: '',
                        params: {remember_token: this.$root.getToken()}
                    }).then(response => {
                        console.log(response.data.data);
                        this.authorised = response.data.data.authorised;
                    })

                }
                catch
                {}
                if (!this.authorised) {
                    this.$router.push({name: 'User Dashboard'});
                }*/
            }
        }
    }
</script>

<style scoped>
    .btn-bottom-margin { margin-bottom: 10px; }
</style>