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

mix.js('resources/js/client/app.js', 'public/js/app.js').vue()
    .js('resources/js/admin/app.js', 'public/js/admin.js').vue()
    .extract([
        'vue',
        'vuex',
        'axios',
        'bootstrap',
        '@inertiajs/inertia',
        '@inertiajs/inertia-vue3',
        '@inertiajs/progress',
        'lodash',
        'sweetalert2',
        'vee-validate',
        'jquery'
    ])
    .sass('resources/css/app.scss', 'public/css/app.css')
    .sass('resources/css/admin.scss', 'public/css/admin.css')
    .webpackConfig(require('./webpack.config'))
    // .alias({
    //     ziggy: path.resolve("vendor/tightenco/ziggy/dist/vue"),
    // })
    .version();

if (mix.inProduction()) {
    mix.version();
}