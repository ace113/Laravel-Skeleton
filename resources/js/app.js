require("./bootstrap");

import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store/index';
import veeValidate from './veeValidate';
import axios from 'axios';
import AwaitingButton from './components/AwaitingButton';


Vue.config.productionTip = false;
Vue.component('AwaitingButton', AwaitingButton);

axios.interceptors.response.use(
    response => response,
    error => {
        console.log('current route', router.currentRoute.name)
        if(error.response.status === 422){
            store.commit('setErrors', error.response.data.errors);
        }else if(error.response.status === 400){
            router.push({name: 'NotFound'});
        }else if(router.currentRoute.name !== "Login" && error.response.status === 401){
            console.log('hello for login')
            router.push({name: "Login"})
        }else{
            return Promise.reject(error);
        }
    }
);

axios.interceptors.request.use(function(config){
    config.headers.common = {
        Authorization: JSON.parse(localStorage.getItem('bearer_token')),
        "Content-Type": "application/json",
        Accept: "application/json"
    };
    return config;
})


const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router,
    store
}).$mount('#app');

