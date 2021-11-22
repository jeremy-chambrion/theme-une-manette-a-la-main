'use strict';

const browserify = require('browserify');
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const cleancss = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const pump = require('pump');
const rev = require('gulp-rev');
const babel = require('gulp-babel');
const del = require('del');

const clean = () => {
    return del(['assets']);
};

const javascript = (cb) => {
    pump([
        browserify([
            './src/js/bootstrap.js'
        ]).bundle(),
        source('bootstrap.js'),
        buffer(),
        sourcemaps.init(),
        babel({presets: ['@babel/env']}),
        uglify(),
        rev(),
        sourcemaps.write('.'),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const minify = (cb) => {
    pump([
        gulp.src([
            './src/js/service-worker.js',
            './node_modules/lazysizes/lazysizes.js'
        ]),
        sourcemaps.init(),
        babel({presets: ['@babel/env']}),
        uglify(),
        rev(),
        sourcemaps.write('.'),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const css = (cb) => {
    pump([
        gulp.src('./src/sass/style.scss'),
        sass({
            outputStyle: 'expanded',
            precision: 8
        }),
        autoprefixer(),
        rename('style.css'),
        sourcemaps.init(),
        cleancss(),
        rev(),
        sourcemaps.write('.', {includeContent: false}),
        gulp.dest('./assets'),
        rev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const fonts = (cb) => {
    pump([
        gulp.src([
            './node_modules/font-awesome/fonts/*',
            './node_modules/bootstrap-sass/assets/fonts/bootstrap/*'
        ]),
        gulp.dest('./assets/fonts')
    ], cb);
};

const logo = (cb) => {
    pump([
        gulp.src([
            './src/logo/*'
        ]),
        gulp.dest('./assets/logo')
    ], cb);
};

exports.build = gulp.series(
    clean,
    gulp.parallel(
        gulp.series(javascript, minify, css),
        fonts,
        logo
    )
);

exports.watch = () => {
    gulp.watch('./src/sass/*.scss', css);
    gulp.watch('./src/js/*.js', gulp.series(javascript, minify));
};
