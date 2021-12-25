<template>
    <div class="subscribe">
        <div class="subscribe__content container">
            <h3>Subscribe to our newsletter</h3>
            <form class="subscribe__content--form">
                <input
                    type="text"
                    name="email"
                    id="email"
                    class="subscribe__content--input"
                    placeholder="Enter email address"
                />
                <button type="button" class="subscribe__content--btn">
                   <fa-icon :icon="['fas', 'paper-plane']"/>
                </button>
            </form>
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>

</style>
