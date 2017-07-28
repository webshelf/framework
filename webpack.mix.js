const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/assets/js/frontend.js', 'public/js')
   .sass('resources/assets/sass/frontend.scss', 'public/css')
   .version();

 /*
 |--------------------------------------------------------------------------
 | Back End Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory('resources/editor', 'public/packages/webshelf');

mix
    .js('resources/assets/js/backend.js', 'public/js')
    .sass('resources/assets/sass/backend.scss', 'public/css')
    .version();

mix.combine([
    'resources/assets/legacy/bootstrap-3.3.7-dist/css/bootstrap.css',
    'resources/assets/legacy/dataTables/bootstrap.css',
    'resources/assets/legacy/dataTables/rowReorder.dataTables.min.css',
    'resources/assets/legacy/datatables.inline.editor/bootstrap-editable.css',
    'resources/assets/legacy/modals/remodal.css',
    'resources/assets/legacy/modals/remodal-default-theme.css',
    'resources/assets/legacy/toastrNotifications/toastr.css',
    'resources/assets/legacy/charts/morris.css',
    'resources/assets/legacy/pace.min.css',
    'resources/assets/legacy/dashboard.css',
    'app/plugins/**/*.css'
],  'public/css/dashboard.css').version();

mix.combine([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    'resources/assets/legacy/dataTables/jquery.dataTables.js',
    'resources/assets/legacy/dataTables/dataTables.bootstrap.js',
    'resources/assets/legacy/dataTables/dataTables.rowReorder.min.js',
    'resources/assets/legacy/datatables.inline.editor/bootstrap-editable.js',
    'resources/assets/legacy/modals/remodal.js',
    'resources/assets/legacy/toastrNotifications/toastr.min.js',
    'resources/assets/legacy/toastrNotifications/toastr.options.js',
    'resources/assets/legacy/charts/morris.min.js',
    'resources/assets/legacy/charts/raphael-min.js',
    'resources/assets/legacy/custom/tooltip.links.js',
    'resources/assets/legacy/webshelf-buttons.js',
    'resources/assets/legacy/pace.min.js',
    'app/plugins/**/*.js'
], 'public/js/dashboard.js').version();
