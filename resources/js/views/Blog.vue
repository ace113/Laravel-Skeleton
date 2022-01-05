<template>
  <div class="blogPage">
     <page-title-header :title="getBlog.title" />
    <div class="blogPage__container container">     
      <div class="blogPage__content">
        <div v-show="getBlog.image" class="blogPage__content--image">
            <img alt="" :src="getBlog.image_url">
        </div>
        <div class="blogPage__content--title">
          {{ getBlog.title }}
        </div>
        <div class="blogPage__content--body">
          <div class="" v-html="getBlog.body"></div>
        </div>
      </div>
       <div class="blogPage__sidebar">
        <recent-blog/>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import RecentBlog from '../components/RecentBlog.vue';
import PageTitleHeader from '../components/PageTitleHeader.vue';
export default {
  components: { RecentBlog, PageTitleHeader },
  name: "BlogPage",
  data() {
    return {
      recentBlogs: {},
    };
  },
  methods: {
    ...mapActions(["getBlogRequest", "getRecentBlogsRequest"]),
  },
  computed: {
    ...mapGetters(["getBlog"]),
  },
  mounted() {
    const slug = this.$route.params.slug;
    this.getBlogRequest(slug)
      .then((res) => {
        console.log("blog", res);
      })
      .catch((err) => {
        console.log("blogerr", err);
        this.flashError(err.response.data.message);
      });
   
  },
};
</script>
