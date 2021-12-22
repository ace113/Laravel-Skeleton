<template>
  <div class="activation">
    <div class="min-vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h1>You are almost there.</h1>
              <flash-message></flash-message>

              <p>
                Please confirm you email. A verification link has been sent your
                email address ({{email}}).
              </p>
              <p>
                Did not receive the email?
                <button @click.prevent="resendVerificationLink()">
                  Resend
                </button>
              </p>
            </div>
          </div>
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
    };
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