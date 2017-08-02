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

mix.js('resources/assets/js/frontend.js', 'public/assets/')
    .sass('resources/assets/sass/frontend.scss', 'public/assets/')
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

mix.copyDirectory('resources/admin/package', 'public/packages/webshelf');
mix.copyDirectory('resources/admin/images', 'public/packages/webshelf/images/');

mix
    .js('resources/admin/assets/js/backend.js', 'public/assets/')
    .sass('resources/admin/assets/sass/backend.scss', 'public/assets/')
    .version();

mix.combine([
    'resources/admin/assets/legacy/bootstrap-3.3.7-dist/css/bootstrap.css',
    'resources/admin/assets/legacy/dataTables/bootstrap.css',
    'resources/admin/assets/legacy/dataTables/rowReorder.dataTables.min.css',
    'resources/admin/assets/legacy/datatables.inline.editor/bootstrap-editable.css',
    'resources/admin/assets/legacy/modals/remodal.css',
    'resources/admin/assets/legacy/modals/remodal-default-theme.css',
    'resources/admin/assets/legacy/toastrNotifications/toastr.css',
    'resources/admin/assets/legacy/charts/morris.css',
    'resources/admin/assets/legacy/pace.min.css',
    'resources/admin/assets/legacy/dashboard.css',
    'app/plugins/**/*.css'
],  'public/assets/dashboard.css').version();

mix.combine([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    'resources/admin/assets/legacy/dataTables/jquery.dataTables.js',
    'resources/admin/assets/legacy/dataTables/dataTables.bootstrap.js',
    'resources/admin/assets/legacy/dataTables/dataTables.rowReorder.min.js',
    'resources/admin/assets/legacy/datatables.inline.editor/bootstrap-editable.js',
    'resources/admin/assets/legacy/modals/remodal.js',
    'resources/admin/assets/legacy/toastrNotifications/toastr.min.js',
    'resources/admin/assets/legacy/toastrNotifications/toastr.options.js',
    'resources/admin/assets/legacy/charts/morris.min.js',
    'resources/admin/assets/legacy/charts/raphael-min.js',
    'resources/admin/assets/legacy/custom/tooltip.links.js',
    'resources/admin/assets/legacy/webshelf-buttons.js',
    'resources/admin/assets/legacy/pace.min.js',
    'app/plugins/**/*.js'
], 'public/assets/dashboard.js').version();
