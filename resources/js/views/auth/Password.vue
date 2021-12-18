<template>
  <div class="conatainer">
    <div class="main-vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-cneter">
              <h1>Change Password</h1>
              <div v-if="message != ''" class="alert alert-danger">
              {{message}}
            </div>
            </div>
            <div class="card-body">
              <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
                <form @submit.prevent="handleSubmit(changePass)">
                  <div class="form-group">
                    <ValidationProvider
                      vid="current_password"
                      name="Current Password"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        placeholder="Current password"
                        :class="{ 'is-invalid': errors[0] }"
                        class="form-control"
                        v-model="current_password"
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
                    <AwaitingButton
                      type="submit"
                      class="btn btn-success btn-block"
                      >Register</AwaitingButton
                    >
                  </div>
                </form>
              </ValidationObserver>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  name: "Password",
  data(){
      return {
          current_password: "",
          password: "",
          password_confirmation: "",
          message: ''
      };
  },
  mounted(){
      this.$store.commit('setErrors', {});
  },
  computed: {
      ...mapGetters(['errors']),
  },
  methods: {
      ...mapActions(['changePassword']),
      changePass(){
          this.$store.commit('setErrors', {});
          this.message = ''
           let data = {
                current_password: this.current_password,
                password: this.password,
                password_confirmation: this.password_confirmation
            };

          this.changePassword(data).then((res)  => {

          }).catch((error) => {
              this.$refs.observer.setErrors({
                  current_password: this.errors.current_password,
                  password: this.errors.password,
                  password_confirmation: this.errors.password_confirmation
              });
              this.message = error.response.data.message;
          })
      }
  }
};
</script>