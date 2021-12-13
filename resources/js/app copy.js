require("./bootstrap");

import Vue from "vue";
import router from "./router";
import axios from 'axios';
import AwaitingButton from './components/AwaitingButton';

import veeValidate from './veeValidate';

import App from "./views/App";

import firebase from './firebase';

import store from './store/index';

const token = localStorage.getItem('bearer_token')

if(token){
    console.log('access token: ' + token)
    axios.defaults.headers.common['Authorization'] = JSON.parse(token)
}

Vue.component('AwaitingButton', AwaitingButton);

const app = new Vue({
    el: "#app",
    components: {
        App,
    },
    router,
    store,
});

window.axios.interceptors.response.use(
    response => {
        response 
        console.log('success response', response.response)
    },
    error => {
        console.log("response", error.response)
        if(error.response.status === 422){
            store.commit('setErrors', error.response.data.errors);
        }
        // else if(error.response.status === 401){
        //     // store.commit('setUserData', null);
        //     localStoreage.removeItem('bearer_token');
        //     router.push({name: "Login"});
        // }
        else if(error.response.status === 400){
            console.log('hello')
            router.push({name: "NotFound"})
        }
        else if(error.response.status === 401){
            console.log('Forbidden')
            router.push({name: "NotFound"})
        }
        else{
            return Promise.reject(error);
        }
    }
)

