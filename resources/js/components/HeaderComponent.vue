<template>
  <header class="header" id="header">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <router-link :to="{ name: 'Home' }" class="navbar-brand"
          >Laravel Skeleton</router-link
        >
        <button
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarCollapse"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <router-link
                class="nav-link"
                data-toggle="collapse"
                :to="{ name: 'Home' }"
              >
                Home
              </router-link>
            </li>

            <li class="nav-item">
              <router-link
                class="nav-link"
                data-toggle="collapse"
                :to="{ name: 'About' }"
              >
                About
              </router-link>
            </li>
            <li class="nav-item" v-show="isLoggedIn">
              <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'Profile'}">Profile</router-link>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto" style="gap: 1rem;">
              <li class="nav-item" v-show="!isLoggedIn">
                <router-link class="btn btn-primary" :to="{ name: 'Login'}">Login</router-link>
              </li>  
              <li class="nav-item" v-show="!isLoggedIn">
                <router-link class="btn btn-outline-primary" :to="{ name: 'Register'}">Register</router-link>
              </li>  
              <li class="nav-item">
                <a href="javascript:void(0);" v-show="isLoggedIn" @click="logout" class="btn btn-danger">Logout</a>
              </li>  
          </ul>          
        </div>
      </div>
    </nav>
  </header>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
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