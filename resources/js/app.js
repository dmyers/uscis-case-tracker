/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const BootstrapVue = require('bootstrap-vue');
const MomentVue = require('vue-moment');

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(MomentVue);

import { library } from '@fortawesome/fontawesome-svg-core'
import { faFlagUsa, faRedoAlt, faPlus, faPlusCircle, faTimes, faCircleNotch, faChevronRight, faChevronDown, faBookmark, faShippingFast, faHeart } from '@fortawesome/free-solid-svg-icons'
import { faCalendarAlt, faCalendarCheck, faClock, faArrowAltCircleDown, faStickyNote } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faFlagUsa, faRedoAlt, faPlus, faPlusCircle, faTimes, faCircleNotch, faChevronRight, faChevronDown, faBookmark, faShippingFast, faHeart, faCalendarAlt, faCalendarCheck, faClock, faArrowAltCircleDown, faStickyNote);

Vue.component('fa-icon', FontAwesomeIcon);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
