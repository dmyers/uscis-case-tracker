const mix = require('laravel-mix');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');

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

mix.disableNotifications();

mix.webpackConfig({
    plugins: [
        new FaviconsWebpackPlugin({
            logo: './resources/img/logo.png',
            prefix: 'img/',
            cache: './storage/tmp'
        })
    ]
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
