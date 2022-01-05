<template>
  <div class="auth">
    <div class="auth__container container">
      <div class="auth__card">
        <div class="card-body">
              <h2 class="mb-1">You are almost there.</h2>
              <flash-message></flash-message>

              <p class="text-grey mb-1">
                Please confirm you email. A verification link has been sent your
                email address ({{email}}).
              </p>
              <p class="text-grey mb-1">
                Did not receive the email?
               
              </p>
               <button type="button" class="btn btn-primary" @click.prevent="resendVerificationLink()">
                  Resend
                </button>
            </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Activation",
  data() {
    return {
      error: "",
      success: '',
      email: ''
    };
  },
  mounted(){
     this.email = JSON.parse(localStorage.getItem('registered_email'));
  },
  methods: {
    async resendVerificationLink() {
      var formData = {
        email: JSON.parse(localStorage.getItem('registered_email')),
      };
      try {
        const { data } = await axios.post(
          "/api/v1/guest/sendVerificationEmail",
          formData
        );
        if (data) {
          if(data.status === 200){
              this.success = data.message; 
              this.flashSuccess(data.message);             
          }
        }
      } catch (error) {
        this.flashError(error.response.data.message)
        this.error = error.response.data.message;
      }
    },
  },
};
</script>