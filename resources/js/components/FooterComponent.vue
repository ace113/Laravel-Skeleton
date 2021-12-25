<template>
    <footer class="footer" id="footer">
        <div class="footer__top">
            <div class="footer__grid container">
                <div class="footer__grid--logo">
                    <h1>{{app_name}}</h1>
                </div>
                <div class="footer__grid--col1 col">
                    <h2>Site Map</h2>
                    <ul>
                        <li class="footer__item">
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >About</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Contact</router-link
                            >
                        </li>
                    </ul>
                </div>
                <div class="footer__grid--col2 col">
                    <h2>Get Help</h2>
                    <ul>
                        <li class="footer__item">
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                        </li>
                    </ul>
                </div>
                <div class="footer__grid--col3 col">
                    <h2>Site Map</h2>
                    <ul>
                        <li class="footer__item">
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Home</router-link
                            >
                        </li>
                    </ul>
                </div>
                <div class="footer__grid--col4 col">
                    <h2>Get Help</h2>
                    <ul>
                        <li class="footer__item">
                            <router-link class="footer__link" to="#"
                                >FAQs</router-link
                            >
                            <router-link class="footer__link" to="#"
                                >Privacy Policy</router-link
                            >                         
                        </li>
                    </ul>
                </div>
                <div class="footer__grid--social">
                    <button class="footer__grid--social btn" type="button">
                        Download App
                    </button>
                    <div class="footer__grid--social icons">
                        <router-link
                            to="#"
                            class="footer__grid--social btn-icon"
                        >
                            <fa-icon :icon="['fab', 'instagram']" />
                        </router-link>
                        <router-link
                            to="#"
                            class="footer__grid--social btn-icon"
                        >
                            <fa-icon :icon="['fab', 'facebook-f']" />
                        </router-link>
                        <router-link
                            to="#"
                            class="footer__grid--social btn-icon"
                        >
                            <fa-icon :icon="['fab', 'linkedin-in']" />
                        </router-link>
                        <router-link
                            to="#"
                            class="footer__grid--social btn-icon"
                        >
                            <fa-icon :icon="['fab', 'github-alt']" />
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__bottom--copy container">
                <div class="text">
                    Copyright &copy;{{ date }} <strong>{{ app_name }}</strong
                    >. All rights reserved. | Lorem ipsum dolor sit amet consectetur
                </div>
                <div class="footer__developer">
                    Developed By:<strong> Prajwal Maharjan</strong>
                </div>
            </div>
        </div>
    </footer>
</template>
<script>
export default {
    data() {
        return {
            app_name: process.env.MIX_APP_NAME,
        };
    },
    computed: {
        date() {
            return new Date().getFullYear();
        },
    },
};
</script>
