/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('main-time-library-component', require('./components/MainTimeLibraryComponent.vue').default);
// Vue.component('tags-component', require('./components/TagsComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });

// Vue.prototype.$bus = new Vue(); // Global event bus


import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Vuetify from 'vuetify';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuetify);


import Form_add from './components/FormAddRecord';
import Form_edit from './components/FormEditRecord';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'add',
            component: Form_add,
        },
        {
            path: '/edit',
            name: 'edit',
            component: Form_edit,
        },
    ],
});
import store from './store.js';

const app = new Vue({
    router,
    store: new Vuex.Store(store),
    vuetify: new Vuetify(),
}).$mount('#app');

import swal from '../assets/js/sweetalert.min';
