<template>
    <div class="pageTitleHeader">
       <div class="pageTitleHeader__content container">
           <div class="title">
               {{title}}
           </div>
       </div>
    </div>
</template>
<script>
export default {
    props: ['title']
}
</script>
<style lang="scss" scoped>
.pageTitleHeader{
    background: #0f1018;
    padding: 8rem 0;
    // margin-top: -2rem;
    margin-bottom: 2rem;

    .title{
        color: #fff;
        font-size: 2.25rem;
        line-height: 1.5;
        font-weight: 600;
        max-width: 600px;
    }
}
</style>