const mix = require('laravel-mix');

// const path = require('path');
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

// mix.alias({
//     ziggy: path.resolve('vendor/tightenco/ziggy/dist'), // or 'vendor/tightenco/ziggy/dist/vue' if you're using the Vue plugin
// });

mix.js('resources/js/admin.js', 'public/js').vue()
    .js('resources/js/frontend.js', 'public/js').vue()
    .sass('resources/scss/volt.scss', 'public/css')
    .sass('resources/scss/frontend.scss', 'public/css')
    .webpackConfig(require('./webpack.config'))
    .options({
        hmrOptions: {
            host: 'localhost',
            port: process.env.HRM_PORT,
            https: process.env.APP_SCHEME == 'https',
        },
        processCssUrls: false,
    })
    .extract();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
