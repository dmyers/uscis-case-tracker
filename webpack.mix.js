const mix = require('laravel-mix');
const HtmlWebpackPlugin = require('html-webpack-plugin');
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

if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    output: {
         publicPath: ""
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: './resources/views/favicon.html',
            filename: '../resources/views/favicon.blade.php'
        }),
        new FaviconsWebpackPlugin({
            logo: './resources/img/logo.png',
            prefix: 'img/',
            cache: './storage/tmp',
            inject: true,
            favicons: {
                appName: process.env.MIX_APP_NAME,
                start_url: process.env.MIX_APP_URL,
                appleStatusBarStyle: "default"
            }
        })
    ]
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
