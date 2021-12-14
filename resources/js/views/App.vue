<template>
    <div>
        <loading-component ref="loading" />
        <header-component />
        <router-view></router-view>
        <footer-component />
    </div>
</template>
<script>
import FooterComponent from "../components/FooterComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
import LoadingComponent from "../components/LoadingComponent.vue";
export default {
    components: { HeaderComponent, FooterComponent, LoadingComponent },
    mounted(){
      this.$loading = this.$refs.loading
    //   console.log('loading', this)
    }
};
</script>
<style>
.error-text {
    color: crimson;
    font-size: 0.75rem;
}
</style>
