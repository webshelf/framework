
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// https://github.com/RubaXa/Sortable
window.Sortable = require('sortablejs');

// Custom modal box.
// http://www.jacklmoore.com/colorbox/
window.colorbox = require('jquery-colorbox');

// Compile files for the editor.
require('./editor');

// Applications date and time related functions.
require('./datetime');

// allows to filter out table data.
require('./search-tables');

// alerts for deleting stuff.
require('./user-actions');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));

// import VueCharts from 'vue-chartjs'
//
// Vue.component('bar-chart', {
//     extends: VueCharts.Line,
//     mounted () {
//         this.renderChart({
//             labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//             datasets: [
//                 {
//                     label: 'Data One',
//                     backgroundColor: '#2b4162',
//                     data: [40, 39, 10, 40, 39, 50, 50]
//                 }
//             ]
//         }, {responsive: true, maintainAspectRatio: false})
//     }
//
// });
//
// var vm = new Vue({
//     el: '#root'
// });