<template>
    <div>
        <h1>Verify Email</h1>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: "VerifyEmail",
    mounted() {
        this.verifyEmail();
    },
    methods: {
        verifyEmail(){
            const params = this.$route.query;
            
           try {
                const {data} = axios.get('/api/v1/guest/register/verifyEmail', {params});
                if(data){
                    console.log('verified');
                }
           } catch (error) {
               console.log(error)
           }             
        }
    }
}
</script>