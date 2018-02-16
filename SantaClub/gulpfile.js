const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');


elixir((mix) => {

  mix //begin of mix
  .webpack('./resources/assets/js/main.js')

  .styles([

    './node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css',
    './node_modules/gentelella/vendors/nprogress/nprogress.css',
    './node_modules/gentelella/vendors/iCheck/skins/flat/green.css',
    './node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
    './node_modules/gentelella/vendors/jqvmap/dist/jqvmap.min.css',
    './node_modules/gentelella/build/css/custom.min.css',

    './node_modules/font-awesome/css/font-awesome.css',
    './node_modules/sweetalert2/dist/sweetalert2.css',
    './node_modules/toastr/build/toastr.min.css',
    './node_modules/bootstrap-select/dist/css/bootstrap-select.css'
  ],'public/css/vendor.css')


  .scripts([
    './node_modules/vue/dist/vue.js',
    './node_modules/gentelella/vendors/jquery/dist/jquery.min.js',
    './node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js',
    './node_modules/gentelella/vendors/fastclick/lib/fastclick.js',
    './node_modules/gentelella/vendors/nprogress/nprogress.js',
    // './node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js',
    // './node_modules/gentelella/vendors/gauge.js/dist/gauge.min.js',
    // './node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
    // './node_modules/gentelella/vendors/iCheck/icheck.min.js',
    // './node_modules/gentelella/vendors/DateJS/build/date.js',
    // './node_modules/gentelella/vendors/jqvmap/dist/jquery.vmap.js',
    // './node_modules/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js',
    // './node_modules/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js',
    './node_modules/gentelella/build/js/custom.min.js',

    './node_modules/sweetalert2/dist/sweetalert2.js',
    './node_modules/toastr/build/toastr.min.js',
    './node_modules/bootstrap-select/dist/js/bootstrap-select.js',
    './node_modules/jquery-slimscroll/jquery.slimscroll.js',
  ],'public/js/vendor.js')

  .copy([
    './node_modules/font-awesome/fonts',
    './node_modules/node_modules/gentelella/vendors/bootstrap/fonts'
  ], 'public/fonts')

  .copy([
    './node_modules/font-awesome/fonts',
    './node_modules/node_modules/gentelella/vendors/bootstrap/fonts'
  ], 'public/build/fonts')


  // Pages

  .webpack('./resources/assets/js/pages/dashboard.js')
  .webpack('./resources/assets/js/pages/crud.js')
  .webpack('./resources/assets/js/pages/movimentacoes.js')

  .version([
    'public/js/dashboard.js',
    'public/js/crud.js',
    'public/js/movimentacoes.js'
  ])

  // cacheBusting
  .version([
    'public/css/vendor.css',
    'public/js/vendor.js',
  ])

});
