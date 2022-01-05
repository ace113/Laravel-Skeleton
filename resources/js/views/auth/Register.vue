<template>
  <div class="auth">
    <div class="auth__container container">
      <div class="auth__content">
        <div class="auth__content--figure">
          <h1>Welcome</h1>
          <div class="text-small">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem,
            temporibus deleniti. Veritatis enim distinctio libero accusantium
            alias placeat debitis nesciunt eius in.
          </div>
        </div>
        <div class="auth__content--form">
          <h2>Register</h2>
          <div class="text-small text-grey mb-1">Create an account</div>
          <flash-message />
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
              <form @submit.prevent="handleSubmit(register)" autocomplete="off">
                <div class="form-group">
                  <ValidationProvider
                    vid="first_name"
                    name="First Name"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <input
                      type="text"
                      name="first_name"
                      id="firstName"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      placeholder="First Name"
                      v-model="first_name"
                    />
                    <div class="invalid-feedback" v-if="errors[0]">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <ValidationProvider
                    vid="last_name"
                    name="Last Name"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <input
                      type="text"
                      name="last_name"
                      id="lastName"
                      placeholder="Last Name"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      v-model="last_name"
                    />
                    <div class="invalid-feedback" v-if="errors[0]">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <ValidationProvider
                    vid="email"
                    name="Email"
                    rules="required|email"
                    v-slot="{ errors }"
                  >
                    <input
                      type="email"
                      name="email"
                      id="email"
                      placeholder="Email"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      v-model="email"
                    />
                    <div class="invalid-feedback" v-if="errors[0]">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <ValidationProvider
                    vid="phone"
                    name="Phone"
                    rules="required|numeric|digits:10"
                    v-slot="{ errors }"
                  >
                    <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group__prepend">
                        <div class="input-group__text">+977</div>
                      </div>
                      <input
                        type="text"
                        name="phone"
                        id="phone"
                        placeholder="Phone Number"
                        class="form-control"
                        :class="{ 'is-invalid': errors[0] }"
                        v-model="phone"
                      />
                    </div>
                    <div class="invalid-feedback" v-if="errors[0]">
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
                      placeholder="Password"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      v-model="password"
                    />
                    <div class="invalid-feedback" v-if="errors[0]">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <ValidationProvider
                    vid="password_confirmation"
                    name="Password Confirmation"
                    rules="required|confirmed:password"
                    v-slot="{ errors }"
                  >
                    <input
                      type="password"
                      name="password_confirmation"
                      id="password_confirmation"
                      placeholder="Retype Password"
                      class="form-control"
                      :class="{ 'is-invalid': errors[0] }"
                      v-model="password_confirmation"
                    />
                    <div class="invalid-feedback" v-if="errors[0]">
                      {{ errors[0] }}
                    </div>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <!-- <input
                    type="submit"
                    value="Register"
                    class="btn btn-block btn-info text-light"
                  /> -->
                  <AwaitingButton
                    type="submit"
                    class="btn btn-primary btn-block"
                    >Register</AwaitingButton
                  >
                </div>
                <div class="text-grey">
                  By registering you confirm that you accept the
                  <router-link to="#" class="link">Terms and Conditions</router-link>
                  and
                  <router-link to="#" class="link">Privacy Policy</router-link>
                </div>
              </form>
            </ValidationObserver>
          </div>
          <div class="auth__content--text">
            <div class="text-grey">
              Already have an account?
              <router-link :to="{ name: 'Login' }" class="link">Login</router-link>
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
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      password: "",
      password_confirmation: "",
    };
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  computed: {
    ...mapGetters(["errors"]),
  },
  methods: {
    ...mapActions(["registerUser"]),
    register() {
      var data = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        phone: this.phone,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };

      this.registerUser(data)
        .then((res) => {
          console.log("res", res);
          if (res.status === 200) {
            this.$router.push({ name: "Activate" });
          }
        })
        .catch((error) => {
          this.$refs.observer.setErrors({
            first_name: this.errors.first_name,
            last_name: this.errors.last_name,
            phone: this.errors.phone,
            email: this.errors.email,
            password: this.errors.password,
          });
          console.log("err", error.response);
          this.flashError(error.response.data.message);
          // this.message = err.response.data.message;
        });
    },
  },
};
</script>
<style lang="scss" scoped>
input[type="password"] {
  position: relative;
  &::after {
    content: "→";
    position: absolute;
    z-index: 2000;
    width: 100%;
    height: 100%;
    right: -20px;
    top: -20px;
  }
}
</style>