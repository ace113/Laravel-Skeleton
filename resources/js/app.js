require("./bootstrap");

import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store/index';

import axios from 'axios';
import AwaitingButton from './components/AwaitingButton';
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueFlashMessage from 'vue-flash-message';
import Pagination from 'laravel-vue-pagination';

import veeValidate from './veeValidate';
// import plugins
import './plugins/fontawesome'

Vue.config.productionTip = false;
Vue.component('AwaitingButton', AwaitingButton);
Vue.component('pagination', Pagination);

Vue.use(VueFlashMessage, {
    method: 'iPefereQuickSilver',
    messageOptions: {
        timeout: 5000,
        important: true,
        autoEmit: true,
        pauseOnInteract: true,
    }
});

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
    loader.hide();
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
       
        switch (error.response.status) {
            case 422:
                store.commit('setErrors', error.response.data.errors);
                break;
                // case 401:
                //     router.push({name: "Login"});
                //     break;
            case 500:
                router.push({
                    name: "ServerError"
                });
                break;
            case 302:
                router.push({
                    name: "NotFound"
                });
                break;
           
            default:
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
