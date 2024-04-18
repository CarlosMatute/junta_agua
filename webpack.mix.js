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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/select2/dist/css/select2.min.css', 'public/css/select2.min.css')
   .copy('node_modules/select2/dist/js/select2.full.min.js', 'public/js/select2.min.js')
   .copy('node_modules/datatables.net-dt/css/jquery.dataTables.min.css', 'public/css/datatables.min.css')
   .copy('node_modules/datatables.net-dt/js/dataTables.dataTables.min.js', 'public/js/datatables.min.js')
   .copy('resources/css/fixdatatable/arreglarcasilla.css', 'public/css/fixdatatable.css');
