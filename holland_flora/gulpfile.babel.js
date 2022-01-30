'use strict';

// Подключаем gulp и плагины
import gulp from 'gulp';
import del from 'del';
import gulpif from 'gulp-if';
import scss from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import mincss from 'gulp-clean-css';
import groupmedia from 'gulp-group-css-media-queries';
import autoprefixer from 'gulp-autoprefixer';
import plumber from 'gulp-plumber';
import browserSync from 'browser-sync';
import replace from 'gulp-replace';
import favicon from 'gulp-favicons';
import imagemin from 'gulp-imagemin';
import imageminPngquant from 'imagemin-pngquant';
import imageminZopfli from 'imagemin-zopfli';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminGiflossy from 'imagemin-giflossy';
import buffer from 'vinyl-buffer';
import svg from 'gulp-svg-sprite';
import svgmin from 'gulp-svgmin';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import yargs from 'yargs';


// Пути к исходным файлам (src), к готовым файлам (dest), а также к тем, за изменениями которых нужно наблюдать (watch)
export const paths = {
    root: './dist',
    copy: './assets/copy/**/*.*',
    php: {
        src: 'index.php',
        watch: './**/*php'
    },
    styles: {
        src: './src/scss/main.scss',
        watch: './src/scss/**/*.scss',
        dest: './dist/'
    },
    scripts: {
        src: './src/js/main.js',
        watch: './src/js/**/*.js',
        dest: './dist/'
    },
    fonts: {
        src: './src/fonts/**/*.*',
        watch: './src/fonts/',
        dest: './dist/fonts/',
    },
    images: {
        src: [
            './src/images/**/*.{jpg,jpeg,png,gif,tiff,svg, webp}',
            '!./src/images/favicon/*.{jpg,jpeg,png,gif,tiff,svg,ico}',
            '!./src/images/sprite/**/*.*'
        ],
        watch: [
            './src/images/**/*.*',
            '!./src/images/favicon/*.*',
            '!./src/images/sprite/**/*.*'
        ],
        dest: './dist/images/'
    },
    spriteSVG: {
        src: './src/images/sprite/*.svg',
        watch: './src/images/sprite/*.svg',
        dest: './dist/images/sprite/'
    },
    favicons: {
        src: './src/images/favicon/*.*',
        dest: './dist/images/favicons/'
    }
};

// Константы
const argv = yargs.argv,
    production = !!argv.production,
    webpackConfig = {
        entry: {
            main: './src/js/main.js',
        },
        output: {
            filename: '[name].js',
            chunkFilename: '[name].js',
        },

        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        query: {
                            presets: [
                                ['@babel/preset-env', {corejs: 3, useBuiltIns: 'usage'}]
                            ]
                        }
                    }
                }
            ]
        }
    };
webpackConfig.mode = production ? 'production' : 'development';

// Clean
export const clean = (cb) => {
    return del(paths.root).then(() => {
        cb();
    });
};
export const cleanNoImg = (cb) => {
    return del(['dist/**/*.*', '!dist/src/images']).then(() => {
        cb();
    });
};

// Copy static files
export const copyFiles = () => {
    return gulp.src(paths.copy)
        .pipe(gulp.dest(paths.root));
};

// PHP
export const php = () => {
    return gulp.src(paths.php.src)
        .pipe(browserSync.stream());
};

// Styles
export const styles = () => {
    return gulp.src(paths.styles.src)
        .pipe(plumber())
        .pipe(gulpif(!argv.production, sourcemaps.init()))
        .pipe(scss())
        .pipe(groupmedia())
        .pipe(gulpif(argv.production, autoprefixer({
            cascade: false,
            grid: true
        })))
        .pipe(gulpif(argv.production, mincss({
            compatibility: 'ie8', level: {
                1: {
                    specialComments: 0,
                    removeEmpty: true,
                    removeWhitespace: true
                },
                2: {
                    mergeMedia: true,
                    removeEmpty: true,
                    removeDuplicateFontRules: true,
                    removeDuplicateMediaBlocks: true,
                    removeDuplicateRules: true,
                    removeUnusedAtRules: false
                }
            }
        })))
        .pipe(plumber.stop())
        .pipe(gulpif(!argv.production, sourcemaps.write('./')))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream());
};

// Script
export const scripts = () => {
    return gulp.src(paths.scripts.src)
        .pipe(webpackStream(webpackConfig), webpack)
        .pipe(gulp.dest(paths.scripts.dest))
        .on('end', browserSync.reload);
};

// Fonts
export const fonts = () => {
    return gulp.src(paths.fonts.src)
        .pipe(gulp.dest(paths.fonts.dest));
};

// Sprite SVG
export const spriteSVG = () => {
    return gulp.src(paths.spriteSVG.src)
        .pipe(svgmin({
            js2svg: {
                pretty: true
            }
        }))
        .pipe(replace('&gt;', '>'))
        .pipe(svg({
            shape: {
                dest: 'intermediate-svg'
            },
            mode: {
                symbol: {
                    sprite: '../sprite.svg'
                }
            }
        }))
        .pipe(gulp.dest(paths.spriteSVG.dest))
        .on('end', browserSync.reload);
};

// Favicon
export const favicons = () => {
    return gulp.src(paths.favicons.src)
        .pipe(favicon({
            icons: {
                appleIcon: true,
                favicons: true,
                online: false,
                appleStartup: false,
                android: false,
                firefox: false,
                yandex: false,
                windows: false,
                coast: false
            }
        }))
        .pipe(gulp.dest(paths.favicons.dest));
};

// Images
export const images = () => {
    return gulp.src(paths.images.src)
        .pipe(buffer())
        .pipe(gulpif(argv.production, imagemin([
            imageminGiflossy({
                optimizationLevel: 3,
                optimize: 3,
                lossy: 2
            }),
            imageminPngquant({
                speed: 5,
                quality: [0.6, 0.8]
            }),
            imageminZopfli({
                more: true
            }),
            imageminMozjpeg({
                progressive: true,
                quality: 75
            }),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: false},
                    {removeUnusedNS: false},
                    {removeUselessStrokeAndFill: false},
                    {cleanupIDs: false},
                    {removeComments: true},
                    {removeEmptyAttrs: true},
                    {removeEmptyText: true},
                    {collapseGroups: true}
                ]
            })
        ])))
        .pipe(gulp.dest(paths.images.dest))
        .on('end', browserSync.reload);
};

// Serve
export const serve = (cb) => {
    browserSync.init({
        proxy: 'hollandflora.loc',
        notify: false,
        online: true,
        open: true
    });

    gulp.watch(paths.php.watch, gulp.series(php));
    gulp.watch(paths.styles.watch, gulp.series(styles));
    gulp.watch(paths.scripts.watch, gulp.series(scripts));
    gulp.watch(paths.spriteSVG.watch, gulp.series(spriteSVG));
    gulp.watch(paths.images.watch, gulp.series(images));
    gulp.watch(paths.copy, gulp.series(copyFiles));

    return cb();
};

export const development = gulp.series(clean,
    gulp.parallel(php, styles, scripts, fonts, spriteSVG, images, favicons, copyFiles),
    gulp.parallel(serve));
export const build = gulp.series(clean,
    gulp.parallel(php, styles, scripts, fonts, spriteSVG, images, favicons, copyFiles));
export const buildNoImg = gulp.series(cleanNoImg,
    gulp.parallel(php, styles, scripts, fonts, spriteSVG, favicons, copyFiles));

export default development;


