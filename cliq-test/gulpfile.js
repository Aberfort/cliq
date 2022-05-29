const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cssnano = require('gulp-cssnano');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const cache = require('gulp-cache');
const terser = require('gulp-terser');

const paths = {
  scss: 'assets/src/styles/*.scss',
  scssAll: 'assets/src/styles/**/*.scss',
  css: 'assets/dist/css',
  jsAll: [
    'assets/src/js/main.js',
  ],
  js: 'assets/dist/js'
};

gulp.task('scss', function(){
  return gulp.src(paths.scss)
      .pipe(sass())
      .pipe(cssnano({
        reduceIdents: false,
        autoprefixer: {
          browsers: ['last 15 versions', '> 1%', 'ie 8', 'ie 7'],
          add: true
        }
      }))
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest(paths.css))
});

gulp.task('scripts', function() {
  return gulp.src(paths.jsAll)
      .pipe(concat('main.min.js'))
      .pipe(terser())
      .pipe(gulp.dest(paths.js))
});

gulp.task('clear', function () {
  return cache.clearAll();
});

gulp.task('watch', function() {
  gulp.watch([paths.scssAll, paths.scss], gulp.parallel('scss'));
  gulp.watch(paths.jsAll, gulp.parallel('scripts'));
});

gulp.task('default', gulp.parallel('clear', 'watch'));
gulp.task('build', gulp.parallel('clear', 'scss', 'scripts'));