/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import axios from 'axios';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import App from './App.vue';
import { routes } from './routes';
import misc from './store/misc'
import Vuex from 'vuex'
import Vue from 'vue';
window.Vue = require('vue');


axios.defaults.headers.post['Content-Type'] = 'application/json;charset=UTF-8';
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(Vuex);
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
    store: misc
});


