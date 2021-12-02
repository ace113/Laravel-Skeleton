import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth'
import pages from './modules/pages'
// load vuex
Vue.use(Vuex);


// export 
export default new Vuex.Store({
    modules: {
        auth,
        pages,
    }
});