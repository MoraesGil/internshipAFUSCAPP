const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');


elixir((mix) => {
  mix.webpack('main.js'); // resources/assets/js/app.js
  mix.webpack('./resources/assets/js/pages/dashboard.js'); // resources/assets/js/app.js

  mix.styles([
    './node_modules/bootstrap/dist/css/bootstrap.css',
    './node_modules/gentelella/build/css/custom.css',
    './node_modules/font-awesome/css/font-awesome.css',
    './node_modules/sweetalert2/dist/sweetalert2.css',
    './node_modules/animate.css/animate.css',
    './node_modules/bootstrap-select/dist/css/bootstrap-select.css',
    './node_modules/toastr/build/toastr.min.css'
  ],'public/css/vendor.css')

  .scripts([
    './node_modules/vue/dist/vue.js',
    './node_modules/jquery/dist/jquery.js',
    './node_modules/gentelella/build/js/custom.js',
    './node_modules/bootstrap/dist/js/bootstrap.js',
    './node_modules/sweetalert2/dist/sweetalert2.js',
    './node_modules/jquery-slimscroll/jquery.slimscroll.js',
    './node_modules/bootstrap-select/dist/js/bootstrap-select.js',
    './node_modules/toastr/build/toastr.min.js'
  ],'public/js/vendor.js')

  .copy([
    './node_modules/font-awesome/fonts',
    './node_modules/bootstrap/fonts'
  ], 'public/fonts');

  // cacheBusting
  mix.version([
    'public/css/vendor.css',
    'public/js/vendor.js',
    'public/js/dashboard.js',
  ])

});