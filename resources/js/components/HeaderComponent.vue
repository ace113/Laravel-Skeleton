<template>
    <header class="header" id="header">
        <div class="nav container">
            <div class="nav__logo">
              <router-link class="link"  to="/">
                    <h1>
                   {{app_name}}
                </h1>
              </router-link>
            </div>
            <div class="nav__main">
                <ul class="nav__menu">
                    <li class="nav__item">
                        <router-link class="nav__link" :to="{ name: 'Home' }"
                            >Home</router-link
                        >
                    </li>
                    <li class="nav__item">
                        <router-link class="nav__link" :to="{ name: 'About' }"
                            >About</router-link
                        >
                    </li>
                    <li class="nav__item">
                        <router-link class="nav__link" :to="{ name: 'Blogs'}">Blogs</router-link>
                    </li>
                </ul>
            </div>
            <div class="nav__search">
                <form class="nav__search--form">
                    <input
                        type="search"
                        name="search"
                        id="search"
                        class="nav__search--input"                       
                        placeholder="Search here"
                    />
                    <button type="submit" class="nav__search--btn">
                        <fa-icon :icon="['fas', 'search']" />
                    </button>
                </form>
            </div>
            <div class="nav__user">
                <!-- show login/register if not logged in -->
                <div v-show="!isLoggedIn">
                    <router-link class="nav__link" :to="{ name: 'Login' }"
                        >Login</router-link
                    >
                    /
                    <router-link class="nav__link" :to="{ name: 'Register' }"
                        >Register</router-link
                    >
                </div>
            </div>
        </div>
    </header>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
    data() {
        return {
            app_name: process.env.MIX_APP_NAME,
        };
    },
    computed: {
        ...mapGetters(["isLoggedIn"]),
    },
    methods: {
        ...mapActions(["logoutUser"]),
        logout() {
            this.logoutUser("124584");
        },
    },
};
</script>
