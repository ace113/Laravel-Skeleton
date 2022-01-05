<template>
  <header class="header" id="header">
    <div class="header__container container">
      <nav class="nav">
        <!-- nav logo -->
        <div class="nav__logo">
          <router-link to="/"
            ><h2>{{ app_name }}</h2></router-link
          >
        </div>
        <!-- main nav -->
        <ul class="nav__main" :class="isOpen ? 'open': ''">
          <li class="nav__item">
            <router-link class="nav__link" to="/">Home</router-link>
          </li>
          <li class="nav__item">
            <router-link class="nav__link" to="/">About</router-link>
          </li>
          <li class="nav__item">
            <router-link class="nav__link" to="/">Blog</router-link>
          </li>
          <li class="nav__item">
            <router-link class="nav__link" to="#">
              <span>Dropdown</span>
              <div class="nav__main--dropdown">
                <div class="dropdown-inner">
                  <ul>
                    <li>
                      <a href="#">hello</a>
                      <a href="#">hello</a>
                    </li>
                  </ul>
                </div>
              </div>
            </router-link>
          </li>
        </ul>
        <ul class="nav__main nav_main--helper">
          <div v-show="!isLoggedIn">
             <li class="nav__item">
            <router-link class="nav__link" :to="{ name: 'Login'}">Log In</router-link>
          </li>
          </div>
        </ul>
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
      </nav>
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
