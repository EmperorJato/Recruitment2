window._ = require('lodash');
window.axios = require('axios');
window.Vue = require('vue');
import Vue from 'vue';
import vuetify from './vuetify';
import VueRouter from 'vue-router';
import {routes} from './routes';
import App from './App.vue';
import store from "./store";
import {initialize} from './helpers/general';
import { Form, HasError, AlertError } from 'vform';
import VeeValidate from 'vee-validate';
import ScrollAnimation from './directives/scrollanimation';
import DatetimePicker from 'vuetify-datetime-picker'
import AnimateNumbers from './components/Animation/AnimateNumbers.vue';

Vue.use(DatetimePicker)
Vue.directive('scrollanimation', ScrollAnimation);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('animated-number', AnimateNumbers);
Vue.use(VeeValidate);
Vue.use(VueRouter);
window.Form = Form;
window.Swal = require('sweetalert2');
window.Fire = new Vue();


const router = new VueRouter({
    
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    mode : 'history'
});

initialize(store, router);

const app = new Vue({
    el : '#app',
    vuetify,
    router,
    store,
    render : h => h(App)
});
