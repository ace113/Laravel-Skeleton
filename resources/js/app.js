require('./bootstrap');

import Vue from 'vue';
import router from './router';

import App from './views/App';

import firebase from './firebase'

Vue.prototype.$messaging = firebase;


const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router
});
