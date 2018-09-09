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

// Lets combine the module assets to the output frontend.js so its loaded as one location.
mix.combine(['app/Modules/*/Assets/*.js'], 'public/assets/modules.js');
mix.combine(['app/Modules/*/Assets/*.css'], 'public/assets/modules.css');

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

// editor
mix.copyDirectory('resources/admin/package/tinymce', 'public/assets');
mix.copyDirectory('resources/admin/package/elfinder', 'public/packages/barryvdh/elfinder/');
mix.copyDirectory('resources/admin/images', 'public/images');

// mix.copyDirectory('resources/admin/images', 'public/packages/webshelf/images/');

mix
    .js('resources/admin/assets/js/backend.js', 'public/assets/')
    .sass('resources/admin/assets/sass/backend.scss', 'public/assets/')
    .version();
