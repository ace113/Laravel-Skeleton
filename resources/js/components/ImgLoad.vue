<template>
      <clazy-load :src="img_url">
      <!-- The image slot renders after the image loads. -->
      <img :src="img_url">
      <!-- The placeholder slot displays while the image is loading. -->
      <div slot="placeholder">
        <!-- You can put any component you want in here. -->
        Loading....
      </div>
    </clazy-load>
</template>
<script>
export default {
    props: ['img_url']
}
</script>