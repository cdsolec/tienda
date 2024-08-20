const mix = require('laravel-mix');
mix.disableNotifications();

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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ])
    .webpackConfig(require('./webpack.config'));

mix.sass('resources/sass/fontawesome.scss', 'public/css');

mix.styles(['resources/css/cdsolec.css'], 'public/css/cdsolec.css');

mix.styles(['resources/css/dashboard.css'], 'public/css/dashboard.css');

mix.styles(['resources/css/slider.css'], 'public/css/slider.css');

mix.styles(['resources/css/megamenu.css'], 'public/css/megamenu.css');

mix.js('resources/js/welcome.js', 'public/js');

mix.copyDirectory('node_modules/tinymce/icons', 'public/js/tinymce/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/tinymce/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/js/tinymce/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/tinymce/themes');
mix.copy('node_modules/tinymce/jquery.tinymce.js', 'public/js/tinymce/jquery.tinymce.js');
mix.copy('node_modules/tinymce/jquery.tinymce.min.js', 'public/js/tinymce/jquery.tinymce.min.js');
mix.copy('node_modules/tinymce/tinymce.js', 'public/js/tinymce/tinymce.js');
mix.copy('node_modules/tinymce/tinymce.min.js', 'public/js/tinymce/tinymce.min.js');

if (mix.inProduction()) {
    mix.version();
}
