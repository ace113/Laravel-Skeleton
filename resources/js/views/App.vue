<template>
  <div>
    <loading-component ref="loading" />
    <!-- <header-component />
        <router-view></router-view>
        <footer-component /> -->
    <component :is="layout" v-if="layout">
      <router-view :layout.sync="layout" />
    </component>
  </div>
</template>
<script>
import FooterComponent from "../components/FooterComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
import LoadingComponent from "../components/LoadingComponent.vue";

// Load layout components dynamically.
const requireContext = require.context("../layouts", false, /.*\.vue$/);
const layouts = requireContext
  .keys()
  .map((file) => [file.replace(/(^.\/)|(\.vue$)/g, ""), requireContext(file)])
  .reduce((components, [name, component]) => {
    components[name] = component.default || component;
    return components;
  }, {});
export default {
  components: { HeaderComponent, FooterComponent, LoadingComponent },
  mounted() {
    this.$loading = this.$refs.loading;
  },
  data() {
    return {
      layout: this.$route.meta.layout || "div",
    };
  },
};
</script>
<style>
.error-text {
  color: crimson;
  font-size: 0.75rem;
}
</style>
