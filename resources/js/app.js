/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

import Vue from 'vue';
console.log(`Vue version : ${Vue.version}`);
import VueRouter from "vue-router";

window.Vue = Vue;

import axios from 'axios';
import store from './store/index';

Vue.use(VueRouter);

// draggable
import rawDisplayer from "./utilities/infra/raw-displayer.vue";

// Windows Notify
window.events = new Vue();

window.noty = function(notification) {
    window.events.$emit('notification', notification)
}

window.handleErrors = function(error) {
    if(error.response.status === 422) {
        window.noty({
            message: 'Vous avez des erreurs de validation. Veuillez réessayer.',
            type: 'danger'
        })
    }

    window.noty({
        message: 'Quelque chose a mal tourné. Veuillez rafraîchir la page.',
        type: 'danger'
    })
}

import Form from "./utilities/Form";
window.Form = Form;

import router from './routes';

import moment from 'moment'

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
    }
})

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/fr';

// necessaire pour rendre un modal draggable (doit d'abord être installé: 'npm install --save jquery-ui-dist')
import 'jquery-ui-dist/jquery-ui';

import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);


/**
 *  Added 2021-08-27 for b-table
 */
import PortalVue from 'portal-vue'
Vue.use(PortalVue)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import Buefy from 'buefy'
//import 'buefy/dist/buefy.css'
Vue.use(Buefy)
/**
 * end Added
 */

/**
 * Added laravel-permission-to-vuejs
 */
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
//Vue.use(LaravelPermissionToVueJS)
/**
* end Added
*/

import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('person-index', require('./views/persons/index').default);

Vue.component('vue-noty', require('./components/Noty').default);
Vue.component('vue-login', require('./views/Login').default);
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
Vue.component('vue-ctk-date-time-picker', window['vue-ctk-date-time-picker']);
Vue.component('vue-dtpicker', require('./components/vueDTpicker').default);
Vue.component('vue2-datepicker', require('vue2-datepicker').default);
Vue.component('vue-datepicker', require('vuejs-datepicker').default);

Vue.component('dashboard-index', require('./views/dashboard/index').default);
Vue.component('workflows-index', require('./views/workflows/list').default);
Vue.component('workflow-execaction', require('./views/workflowexecactions/show').default);
Vue.component('workflow-execstep', require('./views/workflowexecsteps/show').default);
Vue.component('workflow-flowchart', require('./views/workflows/flowchart').default);
Vue.component('flowchart-vue', require('./views/flowchart-vue/index').default);
Vue.component('vue-mermaid-test', require('./views/vue-mermaid-test/mermaid-test').default);

Vue.component('cheques-upload', require('./views/cheques/upload').default);
Vue.component('cheques-show', require('./views/cheques/show').default);

Vue.component('encaissements-upload', require('./views/encaissements/upload').default);
Vue.component('encaissements-show', require('./views/encaissements/show').default);

Vue.component('enumtypes-index', require('./views/enumtypes/list').default);

Vue.component('reminder-index', require('./views/reminders/list').default);
Vue.component('reminderobject-index', require('./views/reminderobjects/list').default);
Vue.component('systems-index', require('./views/systems/index').default);

Vue.component('btable-test', require('./views/workflowsteps/stepsbtable').default);

Vue.component("rawDisplayer", rawDisplayer);

Vue.component('user-show', require('./views/users/show').default);
Vue.component('user-addupdate', require('./views/users/addupdate').default);

Vue.component('times-circle', require('./components/Icons/TimesCircle').default);
Vue.component('select-angle', require('./components/Form/SelectAngle').default);

Vue.component('search-pagination', require('./components/Search/SearchPagination').default);
Vue.component('search-form', require('./components/Search/SearchForm').default);
Vue.component('search-results', require('./components/Search/SearchResults').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
    router,
});
