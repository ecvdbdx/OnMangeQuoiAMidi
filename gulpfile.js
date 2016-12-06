var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var size = require('gulp-size');
var notify = require('gulp-notify');
var rollup = require('gulp-rollup');
var rename = require('gulp-rename');

/** Tasks */

gulp.task('default', ['sass', 'js'], function () {
  gulp.watch(['src/AppBundle/Resources/public/scss/**/*.scss'], ['sass']);
  gulp.watch(['src/AppBundle/Resources/public/js/app.js'], ['js']);
});

/** Sass */

var sassInput = './src/AppBundle/Resources/public/scss/main.scss';
var sassPaths = [
  './node_modules/material-design-lite/src'
];
var sassOutput = './src/AppBundle/Resources/public/css';
var sassOptions = {
  includePaths: sassPaths,
  errLogToConsole: true,
  outputStyle: 'expanded'
};
var autoprefixerOptions = {
  browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};

gulp.task('sass', function () {
  return gulp
    .src(sassInput)
    .pipe(sourcemaps.init())
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(size({gzip: false, showFiles: true}))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(sourcemaps.write('./'))
    .pipe(notify("CSS file generated"))
    .pipe(gulp.dest(sassOutput));
});

/** JS **/

var jsInput = './src/AppBundle/Resources/public/js/app.js';
var jsOutput = './src/AppBundle/Resources/public/js/';

gulp.task('js', function () {
    return gulp
        .src(jsInput)
        .pipe(sourcemaps.init())
        .pipe(rollup({entry: jsInput}))
        .pipe(sourcemaps.write())
        .pipe(notify("JS file generated"))
        .pipe(rename('bundle.js'))
        .pipe(gulp.dest(jsOutput))
});
