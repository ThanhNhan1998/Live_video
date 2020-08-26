/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '../js/App.vue'

Vue.use(VueRouter)


Vue.config.productionTip = false

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(fab, fas, far)
Vue.component('font-awesome-icon', FontAwesomeIcon)


const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/home',
            name: 'home',
            meta: {
                layout: 'default'
            },

            component: require('./pages/Home.vue').default,
        },

        {
            path: '/index',
            name: 'danh-sach-phong',
            meta: {
                layout: 'default'
            },
            
            component: require('./pages/ListRoom.vue').default,
        },

        {
            path: '/create',
            name: 'tao-phong',
            meta: {
                layout: 'default'
            },
            
            component: require('./pages/CreateRoom.vue').default,
        },

        {
            path: '/room/:id',
            name: 'room',
            meta: {
                layout: 'default'
            },
            
            component: require('./pages/ShowRoom.vue').default,
        },
    ]
})

require('./bootstrap');

window.Vue = require('vue');

Vue.component('default-layout' , require('./layouts/DefaultLayout.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    components: {App},
    template: '<App/>'
});
