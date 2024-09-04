let mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/css')
  .js('resources/js/app.js', 'public/js/');

mix.browserSync('http://127.0.0.1:8000');