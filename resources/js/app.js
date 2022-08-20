require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router';

import http from './Libs/axios-config'
Vue.prototype.$api = http;

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

import router from './Router/index'
import App from './App.vue'



import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
 
window.toastr = require('toastr')
 
Vue.use(VueToastr2)

Vue.use(VueRouter)

const app = new Vue({
  el: '#app',
  router,
  components: { App }
});
