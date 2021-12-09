<template>
    <div>
        <button type="button" class="btn btn-info" @click.prevent="resetPassword()">Reset Password</button>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: "ResetPassword",
    data(){
        return {
            email: '',
            token: '',
            password: "password",
            password_confirmation: "password"
        };
    },
    mounted(){
        this.getParams;
       
    },
    computed: {
        getParams(){
            this.email = "user@user.com";
            this.token = this.$route.params.token;
            
            console.log(
                { 'email': this.email,
                 'token': this.token,}
            );
        }
    },
    methods:{
        resetPassword(){
            var data = {
                'email' : this.email,
                'token': this.token,
                'password': this.password,
                'password_confirmation': this.password_confirmation
            };
            axios.post('/api/v1/guest/password/reset', data).then((res) => {
                console.log(res);
            }).catch((error) => {
                console.log(error);
            })
        }
    }
}
</script>