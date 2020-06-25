import vue from "vue";

require('./bootstrap');

window.Vue = vue;

/** Import various libraries for application */
import VueRouter from "vue-router";
//import vuetify from './plugins/vuetify';
import Vuetify from 'vuetify';
Vue.use(Vuetify);
import moment from 'moment';
import VueMoment from 'vue-moment';
import Vuex from 'vuex';
//import VPopover from 'vue-js-popover';

/** Import configured routes and constants */
import {
    USER_ROOT_URL,
    CLAIMS_ROOT_URL,
    MILEAGE_CLAIMS_FOLDER,
    TIME_CLAIMS_FOLDER
} from './config.js'
import {routes} from './routes.js';

/** Choose Locale */
moment.locale('en-gb');

/** Vue use statements */
Vue.use(VueMoment, { moment });
Vue.use(Vuex);
Vue.use(VueRouter);

//Vue.use(VPopover, { tooltip:true });

/** Load components for application */
// Mileage Claims
//Vue.component('mileage-component',      require(MILEAGE_CLAIMS_FOLDER+'/MileageComponent.vue').default);
//Vue.component('parking-component',      require(MILEAGE_CLAIMS_FOLDER+'/ParkingComponent.vue').default);
//Vue.component('subsistence-component',  require(MILEAGE_CLAIMS_FOLDER+'/SubsistenceComponent.vue').default);
//Vue.component('transport-component',    require(MILEAGE_CLAIMS_FOLDER+'/TransportComponent.vue').default);
//Vue.component('travelclaimitem-component', require(MILEAGE_CLAIMS_FOLDER+'/TravelClaimItemComponent.vue').default);
import ContentTemplate from "./components/ContentTemplate";
Vue.component('ct', ContentTemplate);
Vue.component('example-component', require('./components/ExampleComponent').default);
Vue.component('Breadcrumbs', require('./components/Breadcrumbs').default);
Vue.component('AdminBreadcrumbs', require('./components/AdminBreadcrumbs').default);
Vue.component('Status', require('./components/Status').default);

const store = new Vuex.Store({
    state: {
        //TODO: This is not yet storing or using data
    }
}); //finish up

const router = new VueRouter({
    routes // short for `routes: routes`
});


const app = new Vue({
    data() {
        return {token: ''}
    },

    moment, vuetify: new Vuetify(),
    router, store,

    el: '#app',
    methods: {
        setToken(token)
        {
            this.token = token;
        },
        getToken()
        {
            return this.token;
        }
    }
});
