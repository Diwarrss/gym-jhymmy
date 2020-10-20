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
//definimos la baseurl para axios
axios.defaults.baseUrl = process.env.APP_URL_AXIOS
//Create components and import components
Vue.use(VueRouter)
Vue.use(Vuex)
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.component('example-component', require('./pages/ExampleComponent.vue').default)
Vue.component('nav-bar', require('./components/partials/NavBar.vue').default)
Vue.component('side-bar', require('./components/partials/SideBar.vue').default)

//import out store for vuex
import moduleA from './store/moduleA';
import moduleB from './store/moduleB';
import user from './store/user';
import config from './store/config';

const app = new Vue({
  el: '#app',
  router: new VueRouter(routes),
  store: new Vuex.Store({
    modules: {
      moduleA,
      moduleB,
      user,
      config
    }
  })
});
