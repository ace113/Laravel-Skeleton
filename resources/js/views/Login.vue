<template>
  <div class="container">
    <div class="vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h1 class="text-center">Login</h1>
               <p class="mb-0">
                Don't have an account yet?
                <router-link :to="{name: 'Register'}">Register</router-link>
              </p>
            </div>
            <div class="card-body">
              <form @submit.prevent="login">
                <div class="form-group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email"
                    class="form-control"
                    aria-placeholder="true"
                    v-model="email"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Password"
                    aria-placeholder="true"
                    v-model="password"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="submit"
                    value="Login"
                    class="btn btn-success btn-block"
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
      email: "",
      password: '',
    }
  },
  methods: {
    ...mapActions([
      'userLogin',
    ]),
    login(){
      let email = this.email;
      let password = this.password;
      let data = {
        email : email,
        password : password
      }
      this.userLogin(data)
        .then(() => {
          this.$router.push('/profile')
        })
        .catch(err => console.log(err));
    }
  },
 
};
</script>