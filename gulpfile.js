'use strict';

const browserify = require('browserify');
const gulp = require('gulp');
const gulpSass = require('gulp-sass')(require('sass'));
const gulpRename = require('gulp-rename');
const gulpCleanCss = require('gulp-clean-css');
const gulpSourcemaps = require('gulp-sourcemaps');
const gulpAutoprefixer = require('gulp-autoprefixer');
const gulpUglify = require('gulp-uglify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const pump = require('pump');
const gulpRev = require('gulp-rev');
const gulpBabel = require('gulp-babel');
const del = require('del');
const critical = require('critical');

const clean = () => {
    return del(['assets', 'critical']);
};

const javascript = (cb) => {
    pump([
        browserify([
            './src/js/bootstrap.js'
        ]).bundle(),
        source('bootstrap.js'),
        buffer(),
        gulpSourcemaps.init(),
        gulpBabel({presets: ['@babel/env']}),
        gulpUglify(),
        gulpRev(),
        gulpSourcemaps.write('.'),
        gulp.dest('./assets'),
        gulpRev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const minify = (cb) => {
    pump([
        gulp.src([
            './src/js/service-worker.js',
            './node_modules/lazysizes/lazysizes.js'
        ]),
        gulpSourcemaps.init(),
        gulpBabel({presets: ['@babel/env']}),
        gulpUglify(),
        gulpRev(),
        gulpSourcemaps.write('.'),
        gulp.dest('./assets'),
        gulpRev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const css = (cb) => {
    pump([
        gulp.src('./src/sass/style.scss'),
        gulpSass({
            outputStyle: 'expanded',
            precision: 8
        }),
        gulpAutoprefixer(),
        gulpRename('style.css'),
        gulp.dest('./critical'),
        gulpCleanCss(),
        gulpSourcemaps.init(),
        gulpRev(),
        gulpSourcemaps.write('.', {includeContent: false}),
        gulp.dest('./assets'),
        gulpRev.manifest('assets/rev-manifest.json', {base: 'assets', merge: true}),
        gulp.dest('./assets')
    ], cb);
};

const generateCriticalCss = (cb, src, output) => {
    return critical.generate({
        src,
        css: ['critical/style.css'],
        target: {
            css: `critical/${output}`,
        },
        ignore: {
            atrule: ['@font-face', '@import'],
        }
    }, cb);
};

const criticalHome = (cb) => {
    return generateCriticalCss(
        cb,
        'https://unemanettealamain.fr',
        'home-critical.css'
    );
};

const criticalLatest = (cb) => {
    return generateCriticalCss(
        cb,
        'https://unemanettealamain.fr/les-derniers-articles/',
        'latest-critical.css'
    );
};

const criticalTag = (cb) => {
    return generateCriticalCss(
        cb,
        'https://unemanettealamain.fr/article/category/food/recette/',
        'tag-critical.css'
    );
};

const criticalArticle = (cb) => {
    return generateCriticalCss(
        cb,
        'https://unemanettealamain.fr/article/lego-jurassic-world/',
        'article-critical.css'
    );
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
    ),
    gulp.parallel(
        criticalHome,
        criticalLatest,
        criticalTag,
        criticalArticle
    )
);

exports.watch = () => {
    gulp.watch('./src/sass/*.scss', css);
    gulp.watch('./src/js/*.js', gulp.series(javascript, minify));
};
