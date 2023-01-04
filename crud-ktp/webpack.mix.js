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
 mix.styles([
    //  'public/template/css/all.min.css',
	'public/template/css/adminlte.min.css',
], 
'public/css/template.css').version();

mix.scripts([
    'public/template/js/jquery.min.js',
    'public/template/js/jquery-ui.min.js',
    'public/template/js/bootstrap.bundle.min.js',
    'public/template/js/adminlte.min.js',
    'public/template/js/demo.js',
], 
'public/js/template.js').version();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
