require("./bootstrap");

import Vue from "vue";
import router from "./router";
import axios from 'axios';

import App from "./views/App";

import firebase from './firebase';

import store from './store/index';

const token = localStorage.getItem('bearer_token')

if(token){
    console.log('access token: ' + token)
    axios.defaults.headers.common['Authorization'] = JSON.parse(token)
}

const app = new Vue({
    el: "#app",
    components: {
        App,
    },
    router,
    store,
});
