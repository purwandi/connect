import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    { path: '/', name: 'Home', component: () => import('./pages/home.vue')},
    { path: '/groups', name: 'Groups', component: () => import('./pages/groups/groups.vue') },
    { path: '/groups/create', name: 'GroupsCreate', component: () => import('./pages/groups/groups-create.vue') }
  ]
})

export default router