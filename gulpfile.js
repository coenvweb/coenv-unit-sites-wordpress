// TODO: dev, ./
var gulp = require('gulp');
var rename = require('gulp-rename');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var copy = require('gulp-copy');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-minify-css');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');

gulp.task('main_js', function () {
  return gulp
    .src([  './js/jquery/dist/jquery.js',
            './js/jquery-placeholder/jquery.placeholder.js',
            './js/jquery.cookie/jquery.cookie.js',
            './js/fastclick/fastclick.js',
            './js/foundation/js/foundation.js',
            './js/lodash/lodash.js',
            './js/modernizr/modernizr.js',
            './js/nivo-lightbox/nivo-lightbox.js',
            './js/sizzle/dist/sizzle.js',
            './js/slick.js/slick/slick.js',
            './js/init-foundation.js',
            './js/kitchen-sink.js',
            './js/main.js',
            './js/share.js',
            './js/widget-media-upload.js',
            './js/wp-menufix.js'
         ])
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('app.js'))
    .pipe(gulp.dest('./js/'))
    .pipe(livereload());
  ;
});

gulp.task('sass', function () {
  return gulp
    .src('./scss/app.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
        browsers: ['last 4 versions'],
        cascade: false
    }))
    .pipe(cssmin())
    .pipe(sourcemaps.write('./css/maps'))
    .pipe(rename('app.css'))
    .pipe(gulp.dest('./css'))
    .pipe(livereload());
  ;
});

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('**/*.{html,php}', livereload.reload);
    gulp.watch('scss/**/*.scss', ['sass']);
    gulp.watch('js/**/*.js', ['js']);
});

gulp.task('dev', ["default","watch"]);

gulp.task('js', ["main_js"]);

gulp.task('default', ["js","sass"]);

