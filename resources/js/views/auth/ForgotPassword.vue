<template>
  <div class="min-vh-100 d-flex align-items-center">
    <div class="row w-100 justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h1>Forgot Password</h1>
            <div v-if="message != ''" class="alert alert-success">{{message}}</div>
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
                <AwaitingButton type="submit" class="btn btn-success btn-block"
                  >Submit</AwaitingButton
                >
              </form>
            </ValidationObserver>
          </div>
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
    ...mapActions(["forgotPassword"]),
    forgotPasswordEmail() {
      this.$store.commit("setErrors", {});
      var params = {
        email: this.email,
      };

      this.forgotPassword(params)
        .then((res) => {
          console.log("res", res);
          if (res.status === 200) {
            this.message = res.message;
          }
          if(res.status === 232){
            this.message = res.message;
          }
        })
        .catch((error) => {
          this.$refs.observer.setErrors({
            email: this.errors.email,
          });
          this.message = error.response.data.message
        });
    },
  },
};
</script>