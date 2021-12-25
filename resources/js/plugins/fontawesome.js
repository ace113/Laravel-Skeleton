import Vue from "vue";

import {
    library,
    config
} from "@fortawesome/fontawesome-svg-core";
import {
    FontAwesomeIcon
} from "@fortawesome/vue-fontawesome";

import {
    faSearch,
    faUser,
    faCalendar,
    faPaperPlane,
} from "@fortawesome/free-solid-svg-icons";

import {
    faInstagram,
    faFacebookF,
    faLinkedinIn,
    faGithubAlt,

} from '@fortawesome/free-brands-svg-icons';

library.add(
    faSearch,
    faUser,
    faCalendar,
    faInstagram,
    faFacebookF,
    faLinkedinIn,
    faGithubAlt,
    faPaperPlane,
);

// config.autoAddCss = false;

Vue.component("fa-icon", FontAwesomeIcon);
