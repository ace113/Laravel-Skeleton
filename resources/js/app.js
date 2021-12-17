require("./bootstrap");

import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store/index';
import veeValidate from './veeValidate';
import axios from 'axios';
import AwaitingButton from './components/AwaitingButton';
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
// import Loading from './components/LoadingComponent';



Vue.config.productionTip = false;
Vue.component('AwaitingButton', AwaitingButton);
// Vue.component('Loading', Loading);
Vue.use(VueLoading, {
    color: 'green',
    zIndex: 999,
    canCancel: true,
    container: null,
    isFullPage: true,
    loader: 'dots',
});

let loader = null;


axios.interceptors.request.use(function (config) {
    config.headers.common = {
        Authorization: JSON.parse(localStorage.getItem('bearer_token')),
        "Content-Type": "application/json",
        Accept: "application/json"
    };
    loader = Vue.$loading.show();
    return config;
}, function (error) {
    console.log('request')
    return Promise.reject(error);
})

axios.interceptors.response.use(
    response => {
        loader.hide();
        return response
    },
    error => {
        loader.hide();
        console.log('loader', loader);
        console.log('current route', router.currentRoute.name)
        if (error.response.status === 422) {
            store.commit('setErrors', error.response.data.errors);
        }
         else if (error.response.status === 400) {
            router.push({
                name: 'NotFound'
            });
        } 
        else if (router.currentRoute.name !== "Login" && error.response.status === 401) {
            console.log('hello for login')
            router.push({
                name: "Login"
            })
        } else if(error.response.status >= 500){
            // shom modal error
        } else {
            return Promise.reject(error);
        }
    }
);


const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router,
    store
}).$mount('#app');
