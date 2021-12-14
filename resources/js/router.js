import Vue from "vue";

import VueRouter from "vue-router";
import Home from "./views/Home";
import Login from "./views/auth/Login";
import Register from "./views/auth/Register";
import Profile from "./views/Profile";
import About from "./views/About";
import NotFound from "./views/errors/404";
import ResetPassword from "./views/auth/ResetPassword";
import VerifyEmail from "./views/auth/VerifyEmail";
import Activate from "./views/auth/Activation";

import store from "./store/index";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: "*",
            name: "NotFound",
            component: NotFound,
            meta: {
                title: "404 Not Found",
            },
        },
        {
            path: "/",
            name: "Home",
            component: Home,
            meta: {
                title: "Home",
            },
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
            meta: {
                title: "Login",
                guest: true,
            },
        },
        {
            path: "/register",
            name: "Register",
            component: Register,
            meta: {
                title: "Register",
                guest: true,
            },
        },
        {
            path: "/activate",
            name: "Activate",
            component: Activate,
            meta: {
                title: "Activation",
            },
        },
        {
            path: "/verify/email",
            name: "VerifyEmail",
            component: VerifyEmail,
            meta: {
                title: "Email Verification",
                guest: true,
            },
        },
        {
            path: "/password/reset/:token/:email",
            name: "ResetPassword",
            component: ResetPassword,
            meta: {
                title: "Reset Password",
                guest: true,
            },
        },
        {
            path: "/about",
            name: "About",
            component: About,
            meta: {
                title: "About",
            },
        },
        {
            path: "/profile",
            name: "Profile",
            component: Profile,
            meta: {
                title: "Profile",
                private: true,
            },
        },
    ],
    mode: "history",
    base: process.env.BASE_URL,
});

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
    if (to.matched.some((r) => r.meta.private && !store.getters.isLoggedIn)) {
        next({
            name: "Login",
            params: {
                wantedRoute: to.fullPath,
            },
        });
        return;
    }

    if (to.matched.some((r) => r.meta.guest) && store.getters.isLoggedIn) {
        next({
            name: "Home",
        });
        return;
    }


    next();
});

// title
router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} | Laravel Skeleton`;
    
  
    next();
});

// router.afterEach((to, from, next) => {
//     Vue.$loading.finish();
    
// });

export default router;
