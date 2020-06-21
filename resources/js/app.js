require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = true;
Vue.config.performance = true;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('example', require('./TimeLibrary/App.vue'));

// import App from './TimeLibrary/App.vue';
//
// const app = new Vue({
//     el: '#app',
//     components: {
//         App
//     },
//     render: h => h(App)
// });


//Cruds
// import App from './Cruds/App.vue';
//
// const app = new Vue({
//     el: '#app',
//     components: {
//         App
//     },
//     render: h => h(App)
// });
