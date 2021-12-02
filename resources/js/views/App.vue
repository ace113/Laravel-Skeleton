<template>
  <div>
    <header-component/>
    <router-view></router-view>
    <footer-component/>
  </div>
</template>
<script>
import FooterComponent from "../components/FooterComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
export default {
  components: { HeaderComponent, FooterComponent },
};
</script>