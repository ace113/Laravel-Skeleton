<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>{{getPage ? getPage.title : ''}}</h2>
        <p>
          <span v-html="getPage ? getPage.body : ''"></span>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  name: "About",
  computed: {
      ...mapGetters(['getPage']),
  },
  methods: {
      ...mapActions([
          'getAboutPage'
      ])
  },
  mounted(){
      console.log('mounted about page');
      this.getAboutPage();
  }
};
</script>