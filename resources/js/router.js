import Vue from 'vue';

import VueRouter from 'vue-router';
import axios from 'axios';
import Home from './views/Home';
import Login from './views/Login';
import Register from './views/Register';
import NotFound from './views/404';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [{
            path: '/',
            component: Home,
        },
        {
            path: '/login',
            component: Login,
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: "*",
            component: NotFound
        }
    ],
    mode: 'history'
})

export default router;
