/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css')

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('add-query', require('./components/AddQuery.vue').default);
Vue.component('query-concs', require('./components/QueryConcs.vue').default);
Vue.component('query-cluster', require('./components/QueryCluster.vue').default);
Vue.component('doubles', require('./components/Doubles.vue').default);
Vue.component('add-doubles', require('./components/AddDoubles.vue').default);
Vue.component('add-cluster', require('./components/AddCluster.vue').default);
Vue.component('change-price', require('./components/ChangePrice.vue').default);
Vue.component('change-password', require('./components/ChangePassword.vue').default);
Vue.component('change-stop-list', require('./components/ChangeStopList.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
