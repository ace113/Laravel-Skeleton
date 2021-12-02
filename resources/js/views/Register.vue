<template>
  <div class="container">
    <div class="vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h1 class="text-center">Register</h1>
              <p class="mb-0">
                Already have an account
                <router-link :to="{name: 'Login'}">Login</router-link>
              </p>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleRegister">
                <div class="form-group">
                  <input
                    type="text"
                    name="first_name"
                    id="firstName"
                    class="form-control"
                    placeholder="First Name"
                    v-model="first_name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="last_name"
                    id="lastName"
                    placeholder="Last Name"
                    class="form-control"
                    v-model="last_name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email"
                    class="form-control"
                    v-model="email"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="phone"
                    id="phone"
                    placeholder="Phone Number"
                    class="form-control"
                    v-model="phone"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    class="form-control"
                    v-model="password"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Retype Password"
                    class="form-control"
                    v-model="password_confirmation"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="submit"
                    value="Register"
                    class="btn btn-block btn-info text-light"
                  />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
  data(){
    return {
      first_name: '',
      last_name: '',
      email: '',
      phone: '',
      password: '',
      password_confirmation: ''
    };
  },
  methods: {
    ...mapActions(['registerUser']),
    handleRegister(){
      var data = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        phone: this.phone,
        password: this.password,
        password_confirmation: this.password_confirmation
      }
      try {
        this.registerUser(data);
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>