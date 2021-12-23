<template>
  <div class="img-upload">
    <div class="card">
      <h2>Image upload</h2>
      <div class="card-body">
        <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
          <form
            enctype="multipart/form-data"
            @submit.prevent="handleSubmit(uploadImageRequest)"
          >
            <div class="form-group">
              <ValidationProvider vid="image" name="Image" v-slot="{ errors }">
                <input
                  type="file"
                  name="image"
                  id="image"
                  class="form-control"
                  ref="image"
                  @change="onFilePicked"
                />
                <span class="error-text">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group">
              <input type="submit" value="Upload" class="btn btn-info" />
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "ImageUpload",
  data() {
    return {
      image: {},
    };
  },
  methods: {
    onFilePicked(event) {
      const files = event.target.files;

      //   let filename = files[0].name;
      //   const fileReader = new FileReader();
      //   fileReader.addEventListener("load", () => {
      //     this.imageUrl = fileReader.result;
      //   });
      //   fileReader.readAsDataURL(files[0]);
      this.image = files[0];
    },
    uploadImageRequest() {
      
        console.log(this.image);
        const formData = new FormData();
        formData.append('image', this.image);
        axios.post(
          "/api/v1/auth/profile/upload_image",
          formData, {
            headers: {
              'Content-Type':'multipart/form-data'
            }
          }
        ).then((res) => {
          this.flashSuccess(res.data.data)
        }).catch((error) => {
          this.flashError(error.response.data.message)
        })
      
    },
  },
};
</script>