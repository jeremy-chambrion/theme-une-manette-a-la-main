'use strict';

const browserify = require('browserify');
const gulp = require('gulp');
const sass = require('gulp-sass');
const rename = require('gulp-rename');
const cleancss = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const pump = require('pump');
const clean = require('gulp-clean');
const purify = require('gulp-purifycss');
const rev = require('gulp-rev');
const path = require('path');

gulp.task('js', ['js-bootstrap', 'js-service-worker']);

gulp.task('js-bootstrap', function (cb) {
    pump([
        browserify([
            './src/js/bootstrap.js'
        ]).bundle(),
        source('bootstrap.js'),
        buffer(),
        sourcemaps.init(),
        uglify(),
        rev(),
        sourcemaps.write('.'),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
});

gulp.task('js-service-worker', function (cb) {
    pump([
        gulp.src([
            './src/js/service-worker.js'
        ]),
        sourcemaps.init(),
        uglify(),
        rev(),
        sourcemaps.write('.'),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
});

gulp.task('css', ['js'], function (cb) {
    pump([
        gulp.src('./src/sass/style.scss'),
        sass({
            outputStyle: 'expanded',
            precision: 8
        }),
        autoprefixer(),
        purify(['./**/*.php', './**/*.html', './assets/**/*.js', '!./node_modules']),
        rename('style.css'),
        sourcemaps.init(),
        cleancss(),
        rev(),
        sourcemaps.write('.', {includeContent: false}),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
});

gulp.task('fonts', function (cb) {
    pump([
        gulp.src([
            './node_modules/font-awesome/fonts/*',
            './node_modules/bootstrap-sass/assets/fonts/bootstrap/*'
        ]),
        gulp.dest('./assets/fonts')
    ], cb);
});

gulp.task('logo', function (cb) {
    pump([
        gulp.src([
            './src/logo/*'
        ]),
        gulp.dest('./assets/logo')
    ], cb);
});

gulp.task('watch', ['css'], function () {
    gulp.watch(['./src/sass/*.scss'], ['css']);
    gulp.watch(['./src/js/*.js'], ['js']);
});

gulp.task('clean', function (cb) {
    pump([
        gulp.src([
            'assets'
        ], {read: false}),
        clean()
    ], cb);
});

gulp.task('build', ['css', 'fonts', 'logo']);
