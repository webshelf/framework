
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// https://github.com/RubaXa/Sortable
window.Sortable = require('sortablejs');

// Compile files for the editor.
require('./editor');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));

// new Vue({
//     el: '.webshelf-table'
//     // data: {
//     //     email: {
//     //         value: '',
//     //         status: false,
//     //     },
//     //     password: {
//     //         value: '',
//     //         status: false,
//     //     }
//     // },
//     // // define methods under the `methods` object
//     // methods: {
//     // }
// });