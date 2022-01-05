<template>
  <div class="auth">
    <div class="auth__container container">
      <div class="auth__content">
        <div class="auth__content--form">
          <h2>Login</h2>
          <div class="text-small text-grey mb-1">
            Please fill your email and password to sign in to your account.
          </div>
          <flash-message />
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
              <form @submit.prevent="handleSubmit(login)" autocomplete="off">
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
                <div class="card-text">
                  <router-link :to="{ name: 'ForgotPassword' }" class="link"
                    >Forgot Password</router-link
                  >
                </div>
                <div class="form-group">
                  <!-- <input
                      type="submit"
                      value="Login"
                      class="btn btn-success btn-block"
                    /> -->
                  <AwaitingButton
                    type="submit"
                    class="btn btn-primary btn-block"
                    >Login</AwaitingButton
                  >
                </div>
              </form>
            </ValidationObserver>
          </div>
          <div class="auth__content--or">
            <span></span>
            <span>Or</span>
            <span></span>
          </div>

          <div class="auth__content--oauth">
            <button type="button" class="btn btn-block btn-google">
              <fa-icon :icon="['fab', 'google']" class="icon" />
              <div class="text">
                Sign in with Google
              </div>
            </button>
            <button type="button" class="btn btn-block btn-facebook">
              <fa-icon :icon="['fab', 'facebook-f']" class="icon" />
              <div class="text">
                Sign in with Facebook
              </div>
            </button>
          </div>

          <div class="auth__content--text">     
            <div class="text-grey">
              Don't have an account yet? 
              <router-link :to="{ name: 'Register'}" class="link">Register</router-link>
            </div>
          </div>
        </div>
        <div class="auth__content--figure">
          <h1>Welcome</h1>
          <div class="text-small">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem,
            temporibus deleniti. Veritatis enim distinctio libero accusantium
            alias placeat debitis nesciunt eius in.
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
      this.message = "";
      console.log("clicked");
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
          console.log("err", err.response);
          this.message = err.response.data.message;
          this.flashError(err.response.data.message);
        });
    },
  },
};
</script>