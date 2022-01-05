<template>
    <div class="container">
        <div class="blogList">
            <div
                v-for="(blog, index) in getBlogList.data"
                :key="index"
                class="blogs"
            >
                <blog-card :blog="blog" />
            </div>
        </div>
        <pagination
            :data="getBlogList"
            @pagination-change-page="getBlogs"
        ></pagination>
    </div>
</template>
<script>
import BlogCard from "../components/BlogCard.vue";
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
    components: { BlogCard },
    name: "BlogList",
    mounted() {
        this.getBlogs();
    },
    computed: {
        ...mapGetters(["getBlogList"]),
    },
    methods: {
        ...mapActions(["getBlogListRequest"]),
        getBlogs(page = 1) {          
            const params = {
                page,
                per_page: 10,
            };
            this.getBlogListRequest(params)
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    this.flashError(err.response.data.message);
                });
        },
    },
};
</script>
