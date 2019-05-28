let mix = require('laravel-mix');

mix
    .setPublicPath('../build')
    .setResourceRoot('/admin/build/')
    .js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css')
    .version();