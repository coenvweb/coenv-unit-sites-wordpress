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
var browserSync = require('browser-sync').create();
var mainBowerFiles = require('main-bower-files');

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "cig.local"
    });
});

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
            './js/lib/isotope.pkgd.js',
            './js/lib/imagesloaded.pkgd.js',
            './js/lib/outlayer.js',
            './js/lib/masonry.pkgd.js',
            './js/lib/sizzle.js',
            './js/lib/nivo-lightbox.js',
            './js/lib/iodash.js',
            './js/lib/slick.min.js',
            './js/init-foundation.js',
            './js/kitchen-sink.js',
            './js/share.js',
            './js/alert-closer.js',
            './js/widget-media-upload.js',
            './js/wp-menufix.js',
            './js/main.js',
         ])
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('app.js'))
    .pipe(gulp.dest('./js/'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('sass', function () {
  return gulp
    .src('scss/app.scss')
    .pipe(sourcemaps.init())
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(sourcemaps.write({includeContent: false, sourceRoot: '.'}))
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(autoprefixer({
        browsers: ['last 4 versions'],
        cascade: false
    }))
    .pipe(cssmin())
    .pipe(rename('app.css'))
    .pipe(sourcemaps.write('./maps', {includeContent: false, sourceRoot: '../scss'}))
    .pipe(gulp.dest('./css'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('watch', function () {
    browserSync.init({
        proxy: "cig.local"
    });
    gulp.watch('**/*.{html,php}', browserSync.reload);
    gulp.watch('scss/**/*.scss', ['sass']);
    gulp.watch(['./js/*.js', '!./js/app.js'], ['js']);
;
});

gulp.task('dev', ["default","watch"]);

gulp.task('js', ["bower","main_js"]);

gulp.task('default', ["js","sass"]);

