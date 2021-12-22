<template>
  <div v-if="!hidden"
    class="alert alert-warning"
    :class="{ 'alert-success': type === 'success',
    'alert-danger': type === 'error' }"
  >
    <span>
        <slot></slot>
    </span>
    <button type="button" @click="hide" class="close">&times;</button>
  </div>
</template>
<script>
export default {
  name: "Message",
  props: {
      type: {
          type: String,
          default: "info"
      },
      text: {
          type: String,
          default: "Information"
      },
      hidden: {
          type: Boolean,
          default: false,
      }
  },
  methods: {
      hide() {
          this.hidden = true;
      }
  }  
};
</script>