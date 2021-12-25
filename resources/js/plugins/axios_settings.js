import axios from 'axios';
let loader = null;


axios.interceptors.request.use(function (config) {
    config.headers.common = {
        Authorization: JSON.parse(localStorage.getItem('bearer_token')),
        "Content-Type": "application/json",
        Accept: "application/json"
    };
    // loader = Vue.$loading.show();
    return config;
}, function (error) {
    // loader.hide();
    console.log('request')
    return Promise.reject(error);
})

axios.interceptors.response.use(
    response => {
        // loader.hide();
        return response
    },
    error => {
        // loader.hide();
        // console.log('loader', loader);
        // console.log('current route', router.currentRoute.name)        

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