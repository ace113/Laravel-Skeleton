<template>
  <div class="main-layout">
    <header-component />
    <div class="main">
       <slot />
    </div>
    <subscribe/>
    <footer-component />
  </div>
</template>
<script>
import FooterComponent from "../components/FooterComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
import Subscribe from '../components/Subscribe.vue';
export default {
  name: "Default",
  components: { HeaderComponent, FooterComponent, Subscribe },
};
</script>
     