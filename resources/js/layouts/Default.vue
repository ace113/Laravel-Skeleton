<template>
  <div class="main-layout">
    <header-component />
    <child />
    <footer-component />
  </div>
</template>
<script>
import FooterComponent from "../components/FooterComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
export default {
  name: "Default",
  components: { HeaderComponent, FooterComponent },
};
</script>
        HeaderComponent