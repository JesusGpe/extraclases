let mix = require('laravel-mix');

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

mix.styles([
    'resources/assets/plantilla/css/bootstrap.min.css',
    'resources/assets/plantilla/css/font-awesome.css',
    'resources/assets/plantilla/css/AdminLTE.min.css',
    'resources/assets/plantilla/css/_all-skins.min.css',
    'resources/assets/plantilla/css/main.css'
    ], 'public/css/plantilla.css')
.scripts([
    'resources/assets/plantilla/js/jQuery-2.1.4.min.js',
    'resources/assets/plantilla/js/bootstrap.min.js',
    'resources/assets/plantilla/js/aplicacion.min.js',
    'resources/assets/plantilla/js/sweetalert2.all.min.js'
], 	'public/js/plantilla.js')
.js(['resources/assets/js/app.js'], 'public/js/app.js');