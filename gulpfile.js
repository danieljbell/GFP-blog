var gulp          = require('gulp'),
    postcss       = require('gulp-postcss'),
    sass          = require('gulp-sass'),
    sourcemaps    = require('gulp-sourcemaps'),
    atImport      = require('postcss-import'),
    autoprefixer  = require('autoprefixer'),
    mqpacker      = require('css-mqpacker'),
    cssnano       = require('cssnano'),
    imagemin      = require('gulp-imagemin'),
    concat        = require('gulp-concat'),
    uglify        = require('gulp-uglify'),
    pump          = require('pump'),
    browserSync   = require('browser-sync'),
    clean = require('gulp-clean');

gulp.task('css', function () {
  var processors = [
    atImport,
    autoprefixer({browsers: ['last 6 versions', 'ie 9', 'ie 10', 'ie 11']}),
    mqpacker,
    cssnano
  ];
  gulp.src('./wp-content/themes/gfp/src/css/*.css')
    .pipe(gulp.dest('./dist/css'))
    .pipe(browserSync.stream());
  gulp.src('./wp-content/themes/gfp/src/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss(processors))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./wp-content/themes/gfp/dist/css'))
    .pipe(browserSync.stream());
});

gulp.task('js', function () {
  gulp.src([
    './wp-content/themes/gfp/src/js/lib/atomic.min.js',
    './wp-content/themes/gfp/src/js/lib/dompurify.min.js',
    'node_modules/moment/min/moment.min.js',
    'node_modules/countdown/countdown.js',
    'node_modules/tiny-slider/dist/tiny-slider.js',
    './wp-content/themes/gfp/src/js/lib/moment-countdown.min.js',
    './wp-content/themes/gfp/src/js/modules/helpers.js',
    './wp-content/themes/gfp/src/js/modules/site-header.js',
    './wp-content/themes/gfp/src/js/modules/single-post.js',
    './wp-content/themes/gfp/src/js/modules/single-product.js',
    './wp-content/themes/gfp/src/js/modules/archive-product.js',
    './wp-content/themes/gfp/src/js/modules/quick-order-form.js',
    './wp-content/themes/gfp/src/js/modules/single-comments.js',
    './wp-content/themes/gfp/src/js/modules/ajax-add-to-cart.js',
    './wp-content/themes/gfp/src/js/modules/accordian.js',
    './wp-content/themes/gfp/src/js/modules/tooltip.js',
    './wp-content/themes/gfp/src/js/modules/modal.js',
    './wp-content/themes/gfp/src/js/modules/sign-up-form.js',
    './wp-content/themes/gfp/src/js/modules/sticky-navigation.js',
    './wp-content/themes/gfp/src/js/modules/sticky.js',
    './wp-content/themes/gfp/src/js/modules/cart.js',
    './wp-content/themes/gfp/src/js/modules/checkout.js',
    './wp-content/themes/gfp/src/js/modules/search-bar.js',
    './wp-content/themes/gfp/src/js/modules/current-promos.js',
    './wp-content/themes/gfp/src/js/modules/check-order-status.js',
    './wp-content/themes/gfp/src/js/modules/alerts.js',
    './wp-content/themes/gfp/src/js/modules/account.js',
    './wp-content/themes/gfp/src/js/modules/category.js',
    './wp-content/themes/gfp/src/js/modules/model-selector.js',
  ])
    .pipe(sourcemaps.init())
    .pipe(concat('global.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./wp-content/themes/gfp/dist/js'))
    .pipe(browserSync.stream());
});

gulp.task('js-libs', function () {
  gulp.src('./wp-content/themes/gfp/src/js/lib/admin-phone-order.js')
    .pipe(gulp.dest('./wp-content/themes/gfp/dist/js'));
});

gulp.task('img', function() {
  gulp.src('./wp-content/themes/gfp/src/img/*')
      .pipe(gulp.dest('./wp-content/themes/gfp/dist/img'))
});

gulp.task('watch', function() {
  gulp.watch('./wp-content/themes/gfp/src/scss/**/*.scss', ['css']);
  gulp.watch('./wp-content/themes/gfp/src/css/*.css', ['css']);
  gulp.watch('./wp-content/themes/gfp/src/js/**/*.js', ['js', 'js-libs']);
  gulp.watch('./wp-content/themes/gfp/src/img/*.{png,jpg,gif,svg}', ['img']).on('change', browserSync.reload);
  gulp.watch(['./wp-content/themes/gfp/*.php', './wp-content/themes/gfp/page-templates/*.php',  './wp-content/themes/gfp/partials/**/*.php', './wp-content/themes/gfp/woocommerce/**/*.php']).on('change', browserSync.reload);
});

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "greenfarmparts.local"
    });
});

gulp.task('default', ['css', 'js', 'js-libs', 'img', 'watch', 'browser-sync']);