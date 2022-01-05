<template>
  <div class="auth">
    <div class="auth__container container">
      <div class="auth__content">
        <div class="auth__content--form" >
          <div class="card-body">
            <h2>Forgot Password</h2>
            <div class="text-small text-grey mb-1">
              Enter your email and we'll send you a link to reset your password.
            </div>
            <flash-message></flash-message>
            <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
              <form @click.prevent="handleSubmit(forgotPasswordEmail)">
                <div class="form-group">
                  <ValidationProvider
                    vid="email"
                    name="name"
                    rules="required|email"
                    v-slot="{ errors }"
                  >
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      v-model="email"
                      placeholder="Email"
                    />
                    <div class="invalid-feedback">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <AwaitingButton type="submit" class="btn btn-primary btn-block"
                  >Send Email</AwaitingButton
                >
              </form>
            </ValidationObserver>
          </div>
          <div class="auth__content--text">
             <router-link :to="{ name: 'Login' }" class="link link-back">Back to Login</router-link>
          </div>
        </div>
        <div class="auth__content--figure">

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "ForgotPassword",
  data() {
    return {
      email: "",
      message: {
        type: null,
        text: null,
        hidden: true,
      },
    };
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  computed: {
    ...mapGetters(["errors"]),
  },
  methods: {
    ...mapActions(["forgotPassword"]),
    forgotPasswordEmail() {
      this.$store.commit("setErrors", {});
      // this.message = {}
      var params = {
        email: this.email,
      };

      this.forgotPassword(params)
        .then((res) => {
          console.log("res", res);
          if (res.status === 200) {
            this.flashSuccess(res.message);
          }
          if (res.status === 232) {
            this.flashWarning(res.message);
          }
        })
        .catch((error) => {
          this.$refs.observer.setErrors({
            email: this.errors.email,
          });
          this.flashError(error.response.data.message);
        });
    },
  },
};
</script>