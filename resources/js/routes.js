import {ADMIN_ROOT_URL, CLAIMS_ROOT_URL, USER_ROOT_URL} from "./config";
import TravelClaimItemComponent from "./components/claim/mileage/views/TravelClaimItemComponent";
import HoursClaimItem from "./components/claim/time/views/HoursClaimItem";
import UserDashboard from "./components/user/UserDashboard";
import ExampleComponent from "./components/ExampleComponent";
import ClaimSelect from "./components/claim/ClaimSelect";
import MyClaims from "./components/claim/my/MyClaims";
import UserDetails from "./components/user/UserDetails";
import Messages from "./components/user/messages/Messages";
import MessageDetails from "./components/user/messages/MessageDetails";
import Team from "./components/user/Team";
import TravelClaimDashboard from "./components/claim/dashboards/TravelClaimDashboard";
import TimeClaimDashboard from "./components/claim/dashboards/TimeClaimDashboard";
import AdminDashboard from "./components/admin/AdminDashboard";
import AdminUsers from "./components/admin/users/AdminUsers";
import AdminUser from "./components/admin/users/AdminUser";
import AdminGroups from "./components/admin/users/AdminGroups";
import AdminGroup from "./components/admin/users/AdminGroup";
import AdminUserSessions from "./components/admin/users/AdminUserSessions";
import AuthFormGroups from "./components/admin/authorisation/AuthFormGroups";
import MySubmissions from "./components/claim/my/MySubmissions";
import MyAuthorisations from "./components/claim/my/MyAuthorisations";
import AuthConsole from "./components/claim/authorisation/AuthConsole";
import ClaimStatuses from "./components/admin/claims/ClaimStatuses";
import TransportTypes from "./components/admin/claims/TransportTypes";
import MileageTypes from "./components/admin/claims/MileageTypes";
import HoursWrapper from "./components/claim/time/views/HoursWrapper";
import MileagePPM from "./components/admin/claims/MileagePPM";


export const routes = [
    { path: USER_ROOT_URL, component: UserDashboard, name: "User Dashboard" },
    { path: USER_ROOT_URL+'details', component: UserDetails, name: "My Details" },
    { path: USER_ROOT_URL+'details/update', component: ExampleComponent, name: "Update Details" }, //not in use yet
    { path: USER_ROOT_URL+'messages', component: Messages, name: "Messages" },
    { path: USER_ROOT_URL+'messages/:id', component: MessageDetails, name:"Message" },
    { path: USER_ROOT_URL+'team', component: Team, name:"My Team" },

    { path: CLAIMS_ROOT_URL, component: ClaimSelect, name:"Claim Select" },
    { path: CLAIMS_ROOT_URL+'claims', component: MyClaims, name:"My Claims" },
    { path: CLAIMS_ROOT_URL+'authorisations', component: MyAuthorisations, name:"My Authorisations" },
    { path: CLAIMS_ROOT_URL+'authorisations/console', component: AuthConsole, name:"Authorisation Console" },
    { path: CLAIMS_ROOT_URL+'submissions', component: MySubmissions, name:"My Submissions" },
    { path: CLAIMS_ROOT_URL+'create/travel', component: TravelClaimDashboard, name:"Create Travel Claim" },
    { path: CLAIMS_ROOT_URL+'create/time', component: TimeClaimDashboard, name:"Create Time Claim" },
    { path: CLAIMS_ROOT_URL+'travel', component: TravelClaimItemComponent, name: "Travel Claim" },
    { path: CLAIMS_ROOT_URL+'time', component: HoursWrapper, name: "Time Claims", props:true },

    { path: ADMIN_ROOT_URL, component: AdminDashboard, name: "Admin Dashboard" }, // Need to finish off permission check to reenable dashboard. Once running, can be used on multiple routes
    { path: ADMIN_ROOT_URL + 'users', component: AdminUsers, name: "Admin Users" },
    { path: ADMIN_ROOT_URL + 'users/:id', component: AdminUser, name: "Admin User" },
    { path: ADMIN_ROOT_URL + 'groups/', component: AdminGroups, name: "Admin Groups" },
    { path: ADMIN_ROOT_URL + 'groups/:id', component: AdminGroup, name: "Admin Group" },
    { path: ADMIN_ROOT_URL + 'sessions/', component: AdminUserSessions, name: "Admin Sessions" },
    { path: ADMIN_ROOT_URL + 'agf-members/', component: AuthFormGroups, name: "Admin AuthGroup Members" },
    { path: ADMIN_ROOT_URL + 'claim-statuses/', component: ClaimStatuses, name: "Admin Claim Statuses" },
    { path: ADMIN_ROOT_URL + 'transport-statuses/', component: TransportTypes, name: "Admin Transport Types" },
    { path: ADMIN_ROOT_URL + 'mileage-statuses/', component: MileageTypes, name: "Admin Mileage Types" },
    { path: ADMIN_ROOT_URL + 'mileage-ppms/', component: MileagePPM, name: "Admin Mileage PPM" },


    { path: "*", component: UserDashboard, name: "Home" }
];

/*async beforeEnter(to,from,next) {
    /*try {
        var hasPermission = await store.dispatch("auth/hasPermission");
        if (hasPermission) {
            next()
        }
    } catch (e) {
        next({
            name: "User Dashboard" // back to safety route //
        })
    }/
}*/