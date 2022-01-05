<template>
  <div class="home">
    <!-- hero section -->
    <section class="hero" id="hero">
      <div class="hero__content container">
        <div class="hero__title">Welcome to Laravel Skeleton</div>
        <div class="hero__subtitle">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus
          labore doloribus harum quidem nulla? Doloremque ad aliquid facilis
          culpa nam tempore vero.
        </div>
        <div class="hero__actions">
          <button type="button" class="btn btn-primary">Read More</button>
        </div>
      </div>
    </section>

    <!-- featured section -->
    <section class="featured" id="featured">
      <div class="featured__container container">
        <div class="featured__title header-text">Featured Blog</div>
        <div class="featured__content">
          <div class="featured__content--grid">
            <blog-card
              v-for="(blog, index) in blogs"
              :key="index"
              :blog="blog"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- banner section -->
    <section class="banner" id="banner">
      <div class="banner__container container">
        <div class="banner__content">
          <div class="banner__title header-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora
            dolore ab ad.
          </div>
          <div class="banner__subtitle">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ex quod
            sint dolores. Ab, distinctio neque suscipit odio autem nihil
            delectus iure. Eaque.
          </div>
        </div>
      </div>
    </section>

    <!-- latest section -->
    <section class="latest" id="latest">
      <div class="latest__container container">
        <div class="latest__title">
          <span class="header-text">Latest Blog</span>
          <a href="#">View all --></a>
        </div>
        <div class="latest__content">
          <div class="latest__content--grid">
            <blog-card
              v-for="(blog, index) in blogs"
              :key="index"
              :blog="blog"
            />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import BlogCard from "../components/BlogCard.vue";
import { data } from "./data";
export default {
  components: { BlogCard },
  data() {
    return {
      blogs: {},
    };
  },
  mounted() {
    this.blogs = data;
  },
};
</script>
