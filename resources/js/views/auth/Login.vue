<template>
  <div class="container">
    <div class="min-vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center">
              <h1 class="text-center">Login</h1>
              <p class="mb-0">
                Don't have an account yet?
                <router-link :to="{ name: 'Register' }">Register</router-link>
              </p>
              <flash-message></flash-message>
            </div>
            
            <div class="card-body">              
              <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
                <form @submit.prevent="handleSubmit(login)">
                  <div class="form-group">
                    <ValidationProvider
                      vid="email"
                      name="Email"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Email"
                        class="form-control"
                        :class="{ 'is-invalid': errors[0] }"
                        aria-placeholder="true"
                        v-model="email"
                      />
                      <div class="error-text">
                        {{ errors[0] }}
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="form-group">
                    <ValidationProvider
                      vid="password"
                      name="Password"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        :class="{ 'is-invalid': errors[0] }"
                        placeholder="Password"
                        aria-placeholder="true"
                        v-model="password"
                      />
                      <div class="error-text">
                        {{ errors[0] }}
                      </div>
                    </ValidationProvider>
                  </div>
                  <div class="form-group">
                    <!-- <input
                      type="submit"
                      value="Login"
                      class="btn btn-success btn-block"
                    /> -->
                    <AwaitingButton type="submit" class="btn btn-success btn-block">Login</AwaitingButton>
                  </div>
                </form>
              </ValidationObserver>
              <div class="card-text">
                <router-link :to="{name: 'ForgotPassword'}">Forgot Password</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      email: "",
      password: "",
      message: "",
    };
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  computed: {
    ...mapGetters(["errors"]),
  },
  methods: {
    ...mapActions(["userLogin"]),    
    login() {
      this.$store.commit("setErrors", {});
      this.message = '';
      console.log('clicked')
      let data = {
        email: this.email,
        password: this.password,
      };
      this.userLogin(data)
        .then(() => {
          this.$router.push("/");
        })
        .catch((err) => {
          this.$refs.observer.setErrors({
            email: this.errors.email,
            password: this.errors.password,
          });          
          console.log('err',err.response)
          this.message = err.response.data.message;
          this.flashError(err.response.data.message);
        });
    },
  },
};
</script>