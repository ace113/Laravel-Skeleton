<template>
   <div class="auth">
    <div class="auth__container container">
      <div class="auth__content">
        <div class="auth__content--form">
          <div class="card-body">
            <h2>Reset Password</h2>
            <flash-message></flash-message>
          </div>
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
              <form @submit.prevent="handleSubmit(resetPassword)">
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
                      :class="{ 'is-invalid': errors[0] }"
                      class="form-control"
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
                    class="btn btn-primary btn-block"
                    >Reset Password</AwaitingButton
                  >
                </div>
              </form>
            </ValidationObserver>
          </div>
        </div>
        <div class="auth__content--figure">

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
export default {
    name: "ResetPassword",
    data(){
        return {
            email: '',
            token: '',
            password: "password",
            password_confirmation: "password"
        };
    },
    mounted(){
        this.getParams;
       
    },
    computed: {
        getParams(){
            this.email = "user@user.com";
            this.token = this.$route.params.token;
            
            console.log(
                { 'email': this.email,
                 'token': this.token,}
            );
        }
    },
    methods:{
        resetPassword(){
            var data = {
                'email' : this.email,
                'token': this.token,
                'password': this.password,
                'password_confirmation': this.password_confirmation
            };
            axios.post('/api/v1/guest/password/reset', data).then((res) => {
                console.log(res);
                this.flashSuccess(res.data.data.message)
            }).catch((error) => {
                console.log(error);
                this.flashError(error.response.data.message);
            })
        }
    }
}
</script>