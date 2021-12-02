<template>
    <footer class="footer" id="footer">
        <div class="footer__copy m-2 text-center">
            <p class="text-muted">&copy; {{ date }}. All rights reserved.</p>
        </div>
    </footer>
</template>
<script>
export default {
     computed: {
         date(){
             return new Date().getFullYear();
         }
     }
}
</script>