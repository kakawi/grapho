var gulp = require('gulp');

var compass  = require('gulp-compass');
var minifyCSS = require('gulp-minify-css');

var concatJS = require('gulp-concat');
var uglify = require('gulp-uglify');

var clean = require('gulp-clean');
var rename = require('gulp-rename');
var path = require('path');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');

var livereload = require('gulp-livereload');

var bundle = 'Catalog';
var scssDir = 'src/' + bundle + 'Bundle/Resources/public/scss';
var cssDir = 'src/' + bundle + 'Bundle/Resources/public/css';
var jsDir = 'src/' + bundle + 'Bundle/Resources/public/js';

gulp.task('default', function () {
    gulp.run('styles');
    gulp.run('scripts-min');

    livereload.listen();

    //watch .scss files
    gulp.watch(scssDir + '/*.scss', ['styles']);

    //watch .js files
    gulp.watch(jsDir + '/hlebon/*.js', ['scripts-min']);

});

gulp.task('clean', function() {
    return gulp.src(cssDir)
        .pipe(clean());
});

gulp.task('clean-js', function() {
    return gulp.src(jsDir + "/min")
        .pipe(clean());
});

//the title and icon that will be used for the Grunt notifications
var notifyInfo = {
    title: 'Gulp',
    icon: path.join(__dirname, 'gulp.png')
};

//error notification settings for plumber
var plumberErrorHandler = { errorHandler: notify.onError({
    title: notifyInfo.title,
    icon: notifyInfo.icon,
    message: "Error: <%= error.message %>"
})
};

gulp.task('styles', ['clean'], function () {
    gulp.src(cssDir + '/../lib/font-awesome.min.css')
        .pipe(gulp.dest(cssDir));

    return gulp.src(scssDir + '/application.scss')
        .pipe(plumber(plumberErrorHandler))
        .pipe(compass({
            sass: scssDir
        }))
        .pipe(minifyCSS())
        .pipe(rename('all.min.css'))
        .pipe(gulp.dest(cssDir))
        .pipe(notify({
            title: notifyInfo.title,
            icon: notifyInfo.icon,
            message: '<%= file.relative %> - done!'
        }))
        .pipe(livereload());
});

gulp.task('scripts', ['clean-js'], function() {
    //gulp.src(jsDir + '/hlebon/*.js')
    return gulp.src([ jsDir + '/hlebon/menu-top.js', jsDir + '/hlebon/sidebar.js', jsDir + '/hlebon/observer-resize.js'])
        .pipe(concatJS('last_file_hlebon.js'))
        .pipe(gulp.dest(jsDir));
});

gulp.task('scripts-min', ['scripts'], function() {
    return gulp.src(jsDir + '/*.js')
        //.pipe(uglify())
        .pipe(concatJS('all.js'))

        .pipe(gulp.dest(jsDir + '/min'))
        .pipe(notify({
            title: notifyInfo.title,
            icon: notifyInfo.icon,
            message: '<%= file.relative %> - done!'
        }))
});

gulp.task('clean-require-js', function() {
    return gulp.src("src/CatalogBundle/Resources/public/js-require/min")
        .pipe(clean());
});

gulp.task('copy-template', ['clean-require-js'], function() {
    return gulp.src('src/CatalogBundle/Resources/public/js-require/**/*.tpl')
        .pipe(gulp.dest('src/CatalogBundle/Resources/public/js-require/min'));
});

gulp.task('require-min', ['copy-template'], function() {
    return gulp.src('src/CatalogBundle/Resources/public/js-require/**/*.js')
        .pipe(uglify())
        //.pipe(concatJS('all.js'))

        .pipe(gulp.dest('src/CatalogBundle/Resources/public/js-require/min'))
        //.pipe(notify({
        //    title: notifyInfo.title,
        //    icon: notifyInfo.icon,
        //    message: '<%= file.relative %> - done!'
        //}))
});


