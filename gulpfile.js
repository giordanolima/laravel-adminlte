var gulp = require('gulp');
var gulpif = require('gulp-if');
var urlAdjuster = require('gulp-css-url-adjuster');
var concat = require('gulp-concat');
var concatCss = require('gulp-concat-css');
var csso = require('gulp-csso');
var uglify = require('gulp-uglify');
var rev = require('gulp-rev');
var copy = require('copy');
var args = require('yargs')
        .default('production',false)
        .alias('p','production')
        .argv;
var isProduction = args.production;

// Ajustando path
gulp.task("css-adjust:adminlte-plugin-icheck",function(){
    return gulp.src('resources/assets/bower_components/AdminLTE/plugins/iCheck/flat/blue.css')
        .pipe(urlAdjuster({
             prepend: 'img/'
        }))
        .pipe(gulp.dest('resources/assets/adjusted'));    
});
gulp.task("css-adjust",["css-adjust:adminlte-plugin-icheck"]);

// Concatenando CSS
gulp.task("styles",["css-adjust"],function(){
    var src = [
        "resources/assets/bower_components/AdminLTE/bootstrap/css/bootstrap.css",
        "resources/assets/bower_components/AdminLTE/dist/css/AdminLTE.css",
        "resources/assets/bower_components/AdminLTE/dist/css/skins/skin-blue.css",
        "resources/assets/bower_components/AdminLTE/plugins/datepicker/datepicker3.css",
        "resources/assets/adjusted/blue.css",
        "resources/assets/plugins/dropzone/dropzone.css",
        "resources/assets/plugins/imgareaselect/imgareaselect-animated.css",
        "resources/assets/admin/app.css"
    ];
    return gulp.src(src)
        .pipe(concatCss("all.css",{rebaseUrls : false}))
        .pipe(gulpif(isProduction,csso()))
        .pipe(gulp.dest('resources/assets/merged/admin'));
});

// Concatenando JS
gulp.task('scripts:all', function() {
    var src = [
        "resources/assets/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js",
        "resources/assets/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js",
        "resources/assets/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js",
        "resources/assets/bower_components/AdminLTE/plugins/iCheck/icheck.min.js",
        "resources/assets/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js",
        "resources/assets/bower_components/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js",
        "resources/assets/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js",
        "resources/assets/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js",
        "resources/assets/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js",
        "resources/assets/plugins/bootbox/bootbox.min.js",
        "resources/assets/plugins/dropzone/dropzone.js",
        "resources/assets/plugins/imgareaselect/jquery.imgareaselect.min.js",
        "resources/assets/plugins/jquery-ui/jquery-ui.min.js",
        "resources/assets/plugins/loader/loader.js",
        "resources/assets/bower_components/AdminLTE/dist/js/app.js",
        "resources/assets/admin/app.js"
    ];
    return gulp.src(src)
        .pipe(concat('all.js'))
        .pipe(gulpif(isProduction,uglify()))
        .pipe(gulp.dest('resources/assets/merged/admin'));
});
gulp.task('scripts:login', function() {
    var src = [
        "resources/assets/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js",
        "resources/assets/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js",
        "resources/assets/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"
    ];
    return gulp.src(src)
        .pipe(concat('login.js'))
        .pipe(gulpif(isProduction,uglify()))
        .pipe(gulp.dest('resources/assets/merged/admin'));
});
gulp.task('scripts',["scripts:all","scripts:login"]);

gulp.task('images', function () {
    copy('resources/assets/bower_components/AdminLTE/bootstrap/fonts/*', 'public/build/fonts',function(){});
    copy('resources/assets/plugins/imgareaselect/img/*', 'public/build/admin/img',function(){});
    copy('resources/assets/bower_components/AdminLTE/plugins/iCheck/flat/*', 'public/build/admin/img',function(){});
});

gulp.task('version',["styles","scripts"] ,function () {
    var src = [
        "resources/assets/merged/admin/all.css",
        "resources/assets/merged/admin/all.js",
        "resources/assets/merged/admin/login.js"
    ];
    return gulp.src(src,{ base: "resources/assets/merged" })
        .pipe(rev())
        .pipe(gulp.dest('public/build'))
        .pipe(rev.manifest())
        .pipe(gulp.dest('public/build'));
});


gulp.task('default',["css-adjust","styles","scripts","images","version"]);