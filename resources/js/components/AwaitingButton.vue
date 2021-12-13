<template>
  <button @click="clicked" v-bind="$attrs" :loading="loading">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "AwaitingButton",
  inheritAttrs:"false",
  data() {
    return {
      loading: false
    }
  },
  methods:{
    clicked() {
      this.loading = true;
      this.$emit('click', () => {
        this.loading = false;
      })
    }
  }
};
</script>