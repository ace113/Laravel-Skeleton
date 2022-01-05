<template>
  <div class="blogPage__sidebar--recent">
    <h3>Recent Posts</h3>
    <div v-for="(recent, index) in recentBlogs" :key="index" class="recent">
      <img :src="recent.image_url" alt="" width="32px" height="32px" />
      <h3>{{ recent.title }}</h3>
    </div>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      recentBlogs: {},
    };
  },
  methods: {
    ...mapActions(["getRecentBlogsRequest"]),
  },
  mounted() {
      const params = {};
    this.getRecentBlogsRequest(params)
      .then((res) => {
        console.log("recent", res);
        this.recentBlogs = res;
      })
      .catch((err) => {
        this.flashError(err.response.data.message);
      });
  },
};
</script>