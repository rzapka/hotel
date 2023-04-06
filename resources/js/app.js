import Vue from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import router from "./router/index";
import VueRouter from "vue-router";
import Vuetify from './plugins/vuetify'
require('./bootstrap');

window.Vue = require('vue').default;
Vue.use(VueRouter)
Vue.config.silent = true;

Vue.component('App', require('./components/App').default);

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router,
});
