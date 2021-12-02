<template>
  <div class="container">
    <div class="vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h1 class="text-center">Profile</h1>
              <p class="mb-0">Hello, {{user.first_name}}</p>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleUpdateProfile">
                <div class="form-group">
                  <input
                    type="text"
                    name="first_name"
                    id="firstName"
                    class="form-control"
                    placeholder="First Name"
                    v-model="user.first_name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="last_name"
                    id="lastName"
                    placeholder="Last Name"
                    class="form-control"
                    v-model="user.last_name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email"
                    class="form-control"
                    v-model="user.email"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="phone"
                    id="phone"
                    placeholder="Phone Number"
                    class="form-control"
                    v-model="user.phone"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="submit"
                    value="Update"
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
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Profile",
  data() {
    return {
      user: {},
    };
  },

  created() {
    this.getProfile().then((data)=> {
        this.user = data
    });
    
  },

  methods: {
    ...mapActions(["getProfile", "updateProfile"]),
    handleUpdateProfile() {
      

        this.updateProfile(this.user);
    }
  },
};
</script>
