var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

var sassPaths = [
    './node_modules/foundation-sites/assets'
];

var jsFiles = [
    './node_modules/jquery/dist/jquery.js',
    './node_modules/foundation-sites/dist/foundation.js',
    './src/AppBundle/Resources/public/js/app.js'
];

gulp.task('sass', function () {
    return gulp.src('src/AppBundle/Resources/public/scss/style.scss')
        .pipe($.sass({
            includePaths: sassPaths,
            outputStyle: 'compressed' // if css compressed **file size**
        })
            .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe(gulp.dest('./src/AppBundle/Resources/public/css'));
});

gulp.task('js', function () {
    return gulp.src(jsFiles)
        .pipe($.concat('build.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./src/AppBundle/Resources/public/js/build'))
});

gulp.task('default', ['sass', 'js'], function () {
    gulp.watch(['src/AppBundle/Resources/public/scss/**/*.scss'], ['sass']);
    gulp.watch(['src/AppBundle/Resources/public/js/app.js'], ['js']);
});