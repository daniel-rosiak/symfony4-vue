require('../css/app.scss');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.config.productionTip = false

Vue.use(VueRouter)

import Users from './components/Users.vue';

const routes = [
    { path: '/', component: Users },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

new Vue({
    router,
    render: h => h(Users)
}).$mount('#app')