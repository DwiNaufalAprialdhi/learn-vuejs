/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}



window.Vue = require('vue');

import Vue from 'vue';

import VueRouter from 'vue-router';

import Toasted from 'vue-toasted';

import VuePaginate from 'vue-paginate'

Vue.use(VuePaginate)

Vue.use(Toasted);

Vue.use(VueRouter);

import routes from './router'

Vue.component('navigation', require('./components/Navigation.vue').default);

const app = new Vue({
    el: '#njr',
    router: new VueRouter(routes),

});
