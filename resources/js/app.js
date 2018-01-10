import Vue from 'vue'
import VueRouter from './router'

import AppComponent from './components/app.vue'
import { http } from './services/http'

new Vue({
  el: '#app',
  router: VueRouter,
  render: h => h (AppComponent),
  created () {
    http.init()
  }
})
