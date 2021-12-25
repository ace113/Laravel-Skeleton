<template>
    <div class="blogPage">
        <div class="blogPage__container container">
            <div class="blogPage__content">
                <div v-show="getBlog.image" class="blogPage__content--image">
                    <img :src="getBlog.image_url" alt="" />
                </div>
                <div class="blogPage__content--title">
                    {{ getBlog.title }}
                </div>
                <div class="blogPage__content--body">
                    <div class="" v-html="getBlog.body"></div>
                </div>
            </div>
            <div class="blogPage__sidebar">
                <h3>Recent Posts</h3>
                <div v-for="(recent, index) in recentBlogs" :key="index" class="recent">
                    <img :src="recent.image_url" alt="" width="32px" height="32px">
                    <h3>{{recent.title}}</h3>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
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
