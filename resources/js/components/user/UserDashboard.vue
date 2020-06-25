<template>
    <div v-if="!isLoading">
        <div class="well">
            <p class="lead">
                Welcome {{ currentUser.FirstName }}. You have logged in to Mountbatten's Service portal!
                You can manage your account and interact with various services from this portal.
            </p>
        </div>

        <template v-if="role.includes('Staff')">
            <hr>
            <h2>My information</h2>
            <hr>
            <div class="row">
                <div v-if="currentUser.team.length > 0" class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'My Team'}" class="btn bg-info btn-nav-custom" ><span class="fa fa-paw"></span> My Team</router-link></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'My Details'}" class="btn bg-info btn-nav-custom" ><span class="fa fa-credit-card"></span> My Details</router-link></div>
            </div>

            <h2>Services</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="https://every.education" class="btn bg-success btn-nav-custom" ><span class="fa fa-ticket"></span> Helpdesk calls</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="https://mountbatten.hants.sch.uk/tools/phoneBook" class="btn bg-success btn-nav-custom" ><span class="fa fa-phone"></span> Staff Contact</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="https://mountbatten.hants.sch.uk/tools/attendance" class="btn bg-success btn-nav-custom" ><span class="fa fa-globe"></span> Absences</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="https://mountbatten.hants.sch.uk/tools/lockers" class="btn bg-success btn-nav-custom" ><span class="fa fa-lock"></span> Lockers</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-success btn-nav-custom" ><span class="fa fa-flag"></span> MFL SCORM</a></div>
            </div>

            <h2>Claims</h2>
            <hr>

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'Claim Select'}" class="btn bg-secondary btn-nav-custom"><span class="fa fa-file"></span> New Claim</router-link></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'My Claims'}" class="btn bg-secondary btn-nav-custom"><span class="fa fa-files-o"></span> My Claims</router-link></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><router-link :to="{name:'My Authorisations'}" class="btn bg-secondary btn-nav-custom"><span class="fa fa-file-signature"></span> Authorise Claims</router-link></div>
            </div>
        </template>
        <template v-if="role.includes('Parents')">
            <h2>School Information</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-primary btn-nav-custom-lg">Closure and Isolation Work</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-primary btn-nav-custom"><span class="fa fa-calendar"></span> Calendar</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-primary btn-nav-custom"><span class="fa fa-file-text"></span> Letters</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-primary btn-nav-custom"><span class="fa fa-user"></span> Contact Staff</a></div>

            </div>
            <h2>Useful Information</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Revision and Exams</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Supporting Students</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Digital Advice</a></div>
            </div>
            <h2>Interact with us</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom">Report Absence</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom"><span class="fa fa-handshake"></span> Parents' Evening</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom"><span class="fa fa-money"></span> Payment Portal</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom"><span><img src="/files/images/site/simsoptions.png"></span> Options Online</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom"><span class="fa fa-glasses"></span> Lost Property</a></div>
            </div>
            <h2>Faculty information</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Science Information</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Maths Information</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-secondary btn-nav-custom">Careers/PDL</a></div>
            </div>
        </template>
        <template v-if="role.includes('Students')">
            <h2>Subject Sites</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-primary btn-nav-custom"><span class="fa fa-book"></span> English</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-primary btn-nav-custom"><span class="fa fa-calculator"></span> Maths</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-primary btn-nav-custom"><span class="fa fa-flask"></span> Science</a></div>
            </div>
            <h2>External Resources</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-secondary btn-nav-custom">
                    <span class=""><img src='/files/images/site/kerboodle.png' style="height:33px;" alt=""></span> Kerboodle</a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-secondary btn-nav-custom">
                    <span class=""><img src="/files/images/site/mymaths.png" style="height:33px;" alt=""></span> My Maths</a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-secondary btn-nav-custom">
                    <span class=""><img src="/files/images/site/gcsepod.png" style="height:33px;" alt=""></span> GCSE Pod</a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-secondary btn-nav-custom">
                    <span class=""><img src="/files/images/site/simsoptions.png" style="height:33px;" alt=""></span> SIMS Options</a>
                </div>
            </div>
            <h2>Other Services and Resources</h2>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-info btn-nav-custom"><span class="fa fa-address-book"></span> Pastoral Booking</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-info btn-nav-custom"><span class="fa fa-flag"></span> MFL Active Teach</a></div>

                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-info btn-nav-custom">
                    <span class=""><img src="/files/images/site/remoteaccess.png" style="height:33px;" alt=""></span> Remote Access</a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-info btn-nav-custom"><span class="fa fa-wechat"></span> IT Support</a></div>

                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-info btn-nav-custom"><span class="fa fa-paperclip"></span> Exam Information</a></div>
                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href class="btn bg-info btn-nav-custom"><span class="fa fa-mortar-board"></span> PDL / Careers</a></div>

            </div>

        </template>

    </div>
</template>

<script>
    import {USER_URL,SITE_BASE_URL} from "../../config";

    export default {
        name: "UserDashboard",
        data() {
            return {
                isLoading: true,
                currentUser: { team: {}, },
                role: '',
                x: false
            };
        },
        async created() {
            this.isLoading = true;
            await this.retrieve();
            this.isLoading = false;
        },
        methods:{
            async retrieve(){
                await axios({
                    method: 'get',
                    url: USER_URL,
                    params: {remember_token: this.$root.getToken()}
                }).then(response => {
                    this.currentUser = response.data.data.user;
                    this.role = response.data.data.role;
                });
            }
        }

    }
</script>