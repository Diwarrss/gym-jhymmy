/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')
window.Vue = require('vue')
//Import vue-router and routes
import VueRouter from 'vue-router'
import routes from './routes'
//Import vuex
import Vuex from 'vuex'
//Import bootstrap-vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
//vue-select
import vSelect from 'vue-select'
import "vue-select/dist/vue-select.css";
//vue-calendar
/* import VCalendar from 'v-calendar';
Vue.use(VCalendar); */
//vuelidate
import Vuelidate from 'vuelidate'
//VueSweetalert2
import VueSweetalert2 from 'vue-sweetalert2';
const options = {
  confirmButtonColor: '#41b882',
  cancelButtonColor: '#ff7674',
};
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.component('v-select', vSelect)
//Create components and import components
Vue.use(VueRouter)
Vue.use(Vuex)
// Install BootstrapVue
Vue.use(BootstrapVue)
//vuelidate
Vue.use(Vuelidate)
//VueSweetalert2
Vue.use(VueSweetalert2, options);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.component('example-component', require('./pages/ExampleComponent.vue').default)
Vue.component('nav-bar', require('./components/partials/NavBar.vue').default)
Vue.component('side-bar', require('./components/partials/SideBar.vue').default)

//import out store for vuex
import user from './store/user';
import config from './store/config';
import administration from './store/administration';
import actions from './store/actions';

const app = new Vue({
  el: '#app',
  router: new VueRouter(routes),
  store: new Vuex.Store({
    modules: {
      user,
      config,
      administration,
      actions
    }
  })
});
