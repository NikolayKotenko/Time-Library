require('./bootstrap');

// window.Vue = require('vue');
// import App from '../js/App.vue';
// const app = new Vue({
//     el: '#app',
//     components: {
//         App
//     },
//     render: h => h(App)
// });


window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import MyThingsIndex from './components/vue_router/MyThingsIndex.vue';
import CompaniesCreate from './components/vue_router/MyThingsCreate.vue';
import CompaniesEdit from './components/vue_router/MyThingsEdit.vue';

const routes = [
    {
        path: '/',
        components: {
            MyThingsIndex: MyThingsIndex
        }
    },
    {path: '/admin/companies/create', component: CompaniesCreate, name: 'createCompany'},
    {path: '/admin/companies/edit/:id', component: CompaniesEdit, name: 'editCompany'},
];

const router = new VueRouter({ routes });
console.log(router);

const app = new Vue({ router }).$mount('#app');
console.log(app);
