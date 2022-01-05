<template>
  <div class="pageContent">
    <page-title-header :title="getPage.title" />
    <div class="container">
    <div class="row">
      <div class="col-md-12">
         <flash-message></flash-message>
        <!-- <h2>{{getPage ? getPage.title : ''}}</h2> -->
        <p>
          <span v-html="getPage ? getPage.body : ''"></span>
        </p>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import PageTitleHeader from '../components/PageTitleHeader.vue';
export default {
  components: { PageTitleHeader },
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
      this.getAboutPage()
      .then(res => {
        console.log(res)
        if(res.status === 204){
          this.flashInfo(res.message);
        }
      }).catch(error => {
          this.flashError(error.response.data.message)
      });
  }
};
</script>