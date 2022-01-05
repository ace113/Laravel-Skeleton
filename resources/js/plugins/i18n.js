import Vue from 'vue';
import store from '../store';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'en',
    messages: {}
})

export async function loadMessage(locale){
    if(Object.keys(i18n.getLocaleMessage(locale)).lenght === 0){
    }
}

export default i18n;