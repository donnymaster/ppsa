const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .copy('resources/fonts/', 'public/fonts')
    .copy('resources/images/', 'public/images')
    .copy('resources/js/vendor/', 'public/js/vendor')
    .js('resources/js/app.js', 'public/js')
    .copy('resources/js/modules/copyElementEngine.js', 'public/js/vendor')
    .sass('resources/css/app.sass', 'public/css', {
        processUrls: false,
    })
    .sass('resources/css/icon.sass', 'public/css')
    .version();
