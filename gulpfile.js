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
var mainBowerFiles = require('main-bower-files');

gulp.task('bower', function() {
    return gulp.src(mainBowerFiles())
        // Then pipe it to wanted directory, I use
        // dist/lib but it could be anything really
        .pipe(gulp.dest('js/lib'))
});

gulp.task('main_js', function () {
  return gulp
    .src([  './js/lib/jquery.js',
            './js/lib/fastclick.js',
            './js/lib/jquery.placeholder.js',
            './js/lib/jquery.cookie.js',
            './js/lib/modernizr.js',
            './js/lib/foundation.js',
            './js/lib/get-size.js',
            './js/lib/ev-emitter.js',
            './js/lib/matches-selector.js',
            './js/lib/utils.js',
            './js/lib/item.js',
            './js/lib/outlayer.js',
            './js/lib/masonry.pkgd.js',
            './js/lib/sizzle.js',
            './js/lib/nivo-lightbox.js',
            './js/lib/iodash.js',
            './js/lib/slick.min.js',
            './js/init-foundation.js',
            './js/kitchen-sink.js',
            './js/share.js',
            './js/widget-media-upload.js',
            './js/wp-menufix.js',
          './js/alert-closer.js',
            './js/main.js',
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
;
});

gulp.task('dev', ["default","watch"]);

gulp.task('js', ["bower","main_js"]);

gulp.task('default', ["js","sass"]);

