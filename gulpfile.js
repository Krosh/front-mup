var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir(function (mix) {
    mix.sass('app.scss');
    mix.styles([
        '*.css'
    ]);

    mix.scripts([
        'jquery-1.10.2.min.js',
        'jquery.sidebar.js',
        'handlers.js',
        'jquery.popup.js',
        'progressbar.js',
        'jquery.mCustomScrollbar.js',
        'aja.min.js'
    ]);
});