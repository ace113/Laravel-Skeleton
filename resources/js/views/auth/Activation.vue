<template>
  <div class="activation">
    <div class="min-vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h1>You are almost there.</h1>
              <div v-if="success != ''" class="alert alert-success">
                  {{ success }}
              </div>
              <div v-if="error != ''" class="alert alert-danger">
                {{ error }}
              </div>

              <p v-else>
                Please confirm you email. A verification link has been sent your
                email address.
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