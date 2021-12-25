<template>
    <div class="error">
        <div class="error__status">
            404
        </div>
        <div class="error__title">
            Page Not Found
        </div>
        <div class="error__text">
            Looks like the page you were looking for is no longer here.
        </div>
        <router-link :to="{ name: 'Home'}" class="error__btn">Back To Home</router-link>
       
    </div>
</template>
<script>
export default {
   methods: {
       goHome(){
           this.$router.push({name: "Home"})
       }
   }
}
</script>