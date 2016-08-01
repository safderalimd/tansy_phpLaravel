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

elixir(function(mix) {
    mix.sass('elixir.scss')
       .version('css/elixir.css');
});

// elixir(function(mix) {
//     var bootstrapPath = 'node_modules/bootstrap-sass/assets';
//     mix.sass('app.scss')
//         .browserify('app.js')
//         .copy(bootstrapPath + '/fonts', 'public/fonts')
//         .copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css', 'public/css/datapicker.css')
//         .copy('node_modules/datatables-bootstrap3-plugin/example/css/datatables-bootstrap3.css', 'public/css/datatables-bootstrap3.css')
//         .styles('layout.css');
// });
