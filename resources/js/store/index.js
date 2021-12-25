import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth'
import pages from './modules/pages'
import blogs from './modules/blogs'

// load vuex
Vue.use(Vuex);


// export 
export default new Vuex.Store({
    state: {
        errors: []
    },
    getters: {
        errors: state => state.errors
    },
    mutations: {
        setErrors(state, errors){
            state.errors = errors;
        }
    },
    actions: {},
    modules: {
        auth,
        pages,
        blogs,
    }
});