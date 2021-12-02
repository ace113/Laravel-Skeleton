import Vue from 'vue';

import VueRouter from 'vue-router';
import axios from 'axios';
import Home from './views/Home';
import Login from './views/Login';
import Register from './views/Register';
import Profile from './views/Profile';
import About from './views/About';
import NotFound from './views/404';

import store from './store/index'

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [{
            path: "*",
            name: "NotFound",
            component: NotFound,
            meta: {
                title: "404 Not Found",
            }
        },
        {
            path: '/',
            name: "Home",
            component: Home,
            meta: {
                title: "Home",
            }
        },
        {
            path: '/login',
            name: "Login",
            component: Login,
            meta: {
                title: "Login",
                guest: true
            }
        },
        {
            path: '/register',
            name: "Register",
            component: Register,
            meta: {
                title: "Register",
                guest: true
            }
        },
        {
            path: '/profile',
            name: "Profile",
            component: Profile,
            meta: {
                title: "Profile",
                private: true
            }
        },
        {
            path: '/about',
            name: "About",
            component: About,
            meta: {
                title: 'About'
            }
        },

    ],
    mode: 'history',
    base: process.env.BASE_URL,
})



// router.beforeEach((to, from , next) => {
//     const auth = `${to.meta.auth}`;
//     if(auth === "guest"){

//     }
// })

// router.beforeEach((to, from , next) => {
//     // redirect to login page if not logged in and trying to access a restricted page
//     const publicPages = ['/login', '/', '*', '/register'];
//     const authRequired = !publicPages.includes(to.path);
//     const loggedIn = JSON.parse(localStorage.getItem('bearer_token'));
//     console.log('authrequire: '+authRequired);
//     if(authRequired && !loggedIn){
//         return next({
//             path: '/login',
//             query: { returnUrl: to.path }
//         })
//     }

//     next();
// })

router.beforeEach((to, from, next) => {
    // console.log('to', to.name)
    // console.log('token state', store)
    // if route is private and user state is not null
    if (to.matched.some(r => r.meta.private && !store.getters.isLoggedIn)) {
        next({
            name: 'Login',
            params: {
                wantedRoute: to.fullPath,
            }
        })
        return
    }

    if (to.matched.some(r => r.meta.guest) && store.getters.isLoggedIn) {
        next({
            name: "Home"
        })
        return
    }

    next();
})
// title
router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} | Laravel Skeleton`;
    next();
})
export default router;
