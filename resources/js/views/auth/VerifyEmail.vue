<template>
  <div class="auth">
    <div class="auth__container container">
      <div class="auth__card">
            <div class="card-body">
              <h1>Email Verification</h1>
              <div v-if="success != ''" class="alert alert-success">
                  {{ success }}
              </div>
              <div v-if="error != ''" class="alert alert-danger">
                {{ error }}
              </div>         
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
</template>
<script>
import axios from "axios";
export default {
  name: "VerifyEmail",
  data() {
    return {
        success: "",
        error: "",
    };
  },
  mounted() {
    this.verifyEmail();
  },
  methods: {
    async verifyEmail() {
      const params = this.$route.query;

      try {
        const { data } = await axios.get("/api/v1/guest/register/verifyEmail", {
          params,
        });
        if (data) {
          console.log("verified");
          if (data.status === 200) {
            this.success = data.message+ "Please login."
            setTimeout(() => {
              this.$router.push({ name: "Login" });
            }, 5000);
          }
          if(data.status === 215){
            this.error = data.message
          }
        }
      } catch (error) {
        console.log(error);
         this.error = error.response.data.message;
      }
    },
    async resendVerificationLink() {
      var formData = {
        email: "test@email.com",
      };
      try {
        const { data } = await axios.post(
          "/api/v1/guest/sendVerificationEmail",
          formData
        );
        if (data) {
          console.log(data);
          if(data.status === 200){
              this.success = data.message;              
          }
        }
      } catch (error) {
        console.log(error.response.data.message);
        this.error = error.response.data.message;
      }
    },  
  },
};
</script>