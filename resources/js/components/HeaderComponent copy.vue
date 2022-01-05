<template>
  <header class="header" id="header">
    <div class="nav container">
      <div class="nav__logo">
        <router-link class="link" to="/">
          <h1>
            {{ app_name }}
          </h1>
        </router-link>
      </div>
      <div class="nav__main" :class="isOpen ? 'open': ''">
        <ul class="nav__main--menu">
          <li class="nav__main--item">
            <router-link class="nav__main--link" :to="{ name: 'Home' }"
              >Home</router-link
            >
          </li>
          <li class="nav__main--item">
            <router-link class="nav__main--link" :to="{ name: 'About' }"
              >About</router-link
            >
          </li>
          <li class="nav__main--item">
            <router-link class="nav__main--link" :to="{ name: 'Blogs' }"
              >Blogs</router-link
            >
          </li>
        </ul>
      </div>
      <!-- <div class="nav__search">
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
      </div> -->
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
        <!-- show dropdown -->
        <div class="dropdown" v-show="isLoggedIn">
          <div class="user_info dropdown__btn">
            <fa-icon :icon="['fas', 'user']" /> Hi! User
          </div>
          <div class="dropdown__content">
            <router-link :to="{name: 'Profile'}" class="dropdown__link">Profile</router-link>
            <router-link to="#" class="dropdown__link"
              >Change Password</router-link
            >
            <a href="javascript:void(0)" class="dropdown__link" @click="logout"
              >Logout</a
            >
          </div>
        </div>
      </div>
      <div
        class="nav__hamburger"
        id="hamburger"
        @click="openMenu()"
        onclick="this.classList.toggle('open');"
      >
        <svg width="40" height="40" viewBox="0 0 100 100">
          <path
            class="line line1"
            d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"
          />
          <path class="line line2" d="M 20,50 H 80" />
          <path
            class="line line3"
            d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"
          />
        </svg>
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
       isOpen: false,     
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
    openMenu: function () {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>
