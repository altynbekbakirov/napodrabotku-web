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

//  Front js
mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    'public/js/slick.min.js',
    'resources/js/web/app.js'
], 'public/js/app.js');

// //  Front css
// mix.sass('resources/sass/web/main.scss', 'public/css');
mix.sass('resources/sass/web/app.scss', 'public/css').version();

// mix.options({ processCssUrls: false });

// Bashkaruu side
mix.sass('resources/sass/admin/app.scss', 'public/css/admin/')
    .sourceMaps()


mix.webpackConfig({
    devtool: 'source-map'
}).sourceMaps()

mix.disableNotifications();
