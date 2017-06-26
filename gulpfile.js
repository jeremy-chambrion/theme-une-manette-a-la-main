'use strict';

const browserify = require('browserify');
const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const cleancss = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const pump = require('pump');
const clean = require('gulp-clean');

gulp.task('css', function (cb) {
    pump([
        gulp.src('./src/sass/style.scss'),
        sass({
            outputStyle: 'expanded',
            precision: 8
        }),
        autoprefixer(),
        rename('style-unmodified.css'),
        gulp.dest('.'),
        rename('style.css'),
        sourcemaps.init(),
        cleancss(),
        sourcemaps.write('.', {includeContent: false}),
        gulp.dest('.')
    ], cb);
});

gulp.task('js', function (cb) {
    pump([
        browserify([
            './src/js/bootstrap.js'
        ]).bundle(),
        source('bootstrap.js'),
        buffer(),
        sourcemaps.init(),
        uglify(),
        sourcemaps.write('.'),
        gulp.dest('./assets/js')
    ], cb);
});

gulp.task('fonts', function (cb) {
    pump([
        gulp.src([
            './node_modules/font-awesome/fonts/*'
        ]),
        gulp.dest('./assets/fonts')
    ], cb);
});

gulp.task('watch', function () {
    gulp.watch(['./src/sass/*.scss'], ['css']);
});

gulp.task('clean', function () {
    pump([
        gulp.src([
            'node_modules',
            'assets',
            'style.css',
            'style-unminified.css',
            'style-unmodified.css'
        ], {read: false}),
        clean()
    ]);
});

gulp.task('build', ['css', 'js', 'fonts']);
