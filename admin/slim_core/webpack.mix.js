let mix = require('laravel-mix');

mix
    .setPublicPath('../build')
    .setResourceRoot('/admin/build/')
    .js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css')
    .version();

mix.styles([
    'resources/admin/bootstrap/css/bootstrap.min.css',
    'resources/admin/font-awesome/4.5.0/css/font-awesome.min.css',
    'resources/admin/ionicons/2.0.1/css/ionicons.min.css',
    'resources/admin/plugins/iCheck/minimal/_all.css',
    'resources/admin/plugins/datepicker/datepicker3.css',
    'resources/admin/plugins/select2/select2.min.css',
    'resources/admin/plugins/datatables/dataTables.bootstrap.css',
    'resources/admin/dist/css/AdminLTE.min.css',
    'resources/admin/dist/css/skins/_all-skins.min.css',
    'resources/admin/plugins/jvectormap/jquery-jvectormap.css',
    'resources/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"',
    'resources/admin/plugins/bootstrap-daterangepicker/daterangepicker.css',
    'resources/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    'resources/admin/style.css'
], '../build/css/admin.css');

mix.copy('resources/admin/widget/demonstration.css', '../build/css');

mix.copy('resources/admin/bootstrap/fonts', '../build/fonts');
mix.copy('resources/admin/dist/fonts', '../build/fonts');
mix.copy('resources/admin/dist/img', '../build/img');
mix.copy('resources/admin/plugins/iCheck/minimal/blue.png', '../build/css');

mix.js([
        'resources/admin/scripts.js',
        'resources/admin/bootstrap/js/bootstrap.min.js',
        'resources/admin/plugins/select2/select2.full.min.js',
        'resources/admin/plugins/datepicker/bootstrap-datepicker.js',
        'resources/admin/plugins/datatables/dataTables.bootstrap.css',
        'resources/admin/plugins/slimScroll/jquery.slimscroll.min.js',
        'resources/admin/plugins/fastclick/fastclick.js',
        'resources/admin/plugins/iCheck/icheck.min.js',
        'resources/admin/dist/js/app.min.js',
        'resources/admin/dist/js/scripts.js',
        'resources/admin/plugins/jquery-sparkline/dist/jquery.sparkline.min.js',
        'resources/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'resources/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'resources/admin/plugins/jquery-knob/dist/jquery.knob.min.js'
    ], '../build/js/admin.js');

mix.js('resources/admin/dist/js/dashboard.js', '../build/js/admin/dashboard.js');