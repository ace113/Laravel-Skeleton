<template>
  <div class="container">
    <div class="min-vh-100 d-flex align-items-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center">
              <h1 class="text-center">Profile</h1>
              <!-- <p class="mb-0">Hello, {{user.first_name ? user.first_name: ''}}</p> -->
              <div class="img">
                <img :src="user.image_url" alt="" class="img-fluid img-avatar"/>
              </div>
            </div>
            <div v-if="user" class="card-body">
              <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
                <form @submit.prevent="handleSubmit(profile)">
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
                        v-model="user.first_name"
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
                        v-model="user.last_name"
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
                        v-model="user.email"
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
                        <div class="input-group-prepend">
                          <div class="input-group-text">+977</div>
                        </div>
                        <input
                          type="text"
                          name="phone"
                          id="phone"
                          placeholder="Phone Number"
                          class="form-control"
                          :class="{ 'is-invalid': errors[0] }"
                          v-model="user.phone"
                        />
                      </div>
                      <div class="invalid-feedback" v-if="errors[0]">
                        {{ errors[0] }}
                      </div>
                    </ValidationProvider>
                  </div>                  
                  <div class="form-group">
          
                    <AwaitingButton
                      type="submit"
                      class="btn btn-success btn-block"
                      >Update</AwaitingButton
                    >
                  </div>
                </form>
              </ValidationObserver>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <image-upload/>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import ImageUpload from '../components/ImageUpload';
export default {
  name: "Profile",
  components: {ImageUpload},
  data() {
    return {
      user: {},
    };
  },
  mounted() {
    this.getProfile().then((data)=> {
      
        this.user = data.data
    });
    
  },
  methods: {
    ...mapActions(["getProfile", "updateProfile"]),
    profile() {     

        this.updateProfile(this.user).then((res) => {
          console.log(res)
        }).catch(err => {
          this.$refs.observer.setErrors({
            first_name: this.errors.first_name,
            last_name: this.errors.last_name,
            phone: this.errors.phone,
            email: this.errors.email,
          });
        });
    }
  },
};
</script>
<style lang="scss" scoped>
.img-avatar{
  width: 80px;
  height: 80px;
  object-fit: contain;
  border-radius: 50%;
}
</style>
