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

//Create components
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.component('example-component', require('./pages/ExampleComponent.vue').default)

//import out store for vuex
import moduleA from './store/moduleA';
import moduleB from './store/moduleB';

const app = new Vue({
  el: '#app',
  router: new VueRouter(routes),
  store: new Vuex.Store({
    modules: {
      moduleA,
      moduleB
    }
  })
});
