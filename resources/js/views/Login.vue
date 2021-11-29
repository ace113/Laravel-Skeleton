<template>
  <div class="container">
    <div class="vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h1 class="text-center">Login</h1>
            </div>
            <div class="card-body">
              <form @submit.prevent="login">
                <div class="form-group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email"
                    class="form-control"
                    aria-placeholder="true"
                    v-model="email"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Password"
                    aria-placeholder="true"
                    v-model="password"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="submit"
                    value="Login"
                    class="btn btn-success btn-block"
                  />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data(){
    return {
      email: "",
      password: '',
    }
  },
  methods: {
    async login(){
      try {
        const response = await axios.post('/api/v1/guest/login', {
          email: this.email,
          password: this.password
        });

        console.log(response)
      } catch (error) {
        console.log(error.response)
        if(error.response.status == 401){
          alert(error.response.data.message)
        }
      }
    }
  }
};
</script>