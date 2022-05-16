let fileswatch = 'php,html,htm,txt,json,md,woff2,scss'; // List of files extensions for watching & hard reload
const config   = require( './config' );

// Include necessary modules.
const {src, dest, parallel, watch} = require('gulp');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const uglify = require('gulp-uglify-es').default;
const rigger = require('gulp-rigger');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleancss = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const imagemin = require('gulp-imagemin');
const newer = require('gulp-newer');
const webpackStream                          = require( 'webpack-stream' );
const webpack                                = require( 'webpack' );
const webpackConfig                          = require( './webpack.config.js' );
const minify                                 = require( 'gulp-minify' );

function browsersync() {
	browserSync.init( config.webserver );
}

// Process scripts.
function scripts() {
	return src( 'src/js/*/*.js' )
		.pipe( webpackStream( webpackConfig ) )
		.on(
			'error',
			function handleError() {
				this.emit( 'end' )
			}
		)
		.pipe(
			minify(
				{
					ext:{
						src:'.js',
						min:'.min.js'
					},
					exclude: ['tasks'],
					ignoreFiles: ['.combo.js', '-min.js']
				}
			)
		)
		.pipe( dest( 'dist/js/' ) )
		.pipe( browserSync.stream() )
}

function styles() {
	return src( 'src/scss/**/*.scss' )
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe( sass( { outputStyle: 'compressed' } ) )
		.pipe( autoprefixer( { overrideBrowserslist: ['last 10 versions'], grid: true } ) )
		.pipe(cleancss(({level: {1: {specialComments: 0}}})))
		.pipe(sourcemaps.write())
		.pipe( dest( 'dist/css' ) )
		.pipe( browserSync.stream() )
}

function acfModuleStyles() {
	return src( 'template-parts/blocks/**/*/*.scss', {base: './'} )
		.pipe( sass( { outputStyle: 'compressed' } ) )
		.pipe( autoprefixer( { overrideBrowserslist: ['last 10 versions'], grid: true } ) )
		.pipe( dest( './' ) )
		.pipe( browserSync.stream() )
}

// Minify images.
function images() {
	return src('src/img/**/*')	// Get all files from app/img/src/ directory.
		.pipe(newer('static/img'))	// Only new images (not in destination directory).
		.pipe(imagemin())			// Minimize images.
		.pipe(dest('dist/img/'))	// Output.
}

//Fonts
function fonts() {
	return src('src/fonts/**/*')
		.pipe(dest('dist/fonts/'))
}

// Watch all necessary files.
function startwatch() {
	watch('src/scss/**/*', styles);
	watch('template-parts/blocks/*/*.scss', acfModuleStyles);
	watch(['src/js/**/*.js'], scripts);
	watch('**/*.php').on('change', browserSync.reload);
	watch('src/**/*', images);
	watch('src/fonts/**/*', fonts)
}

// Export all functions to run by default or single.
exports.browsersync = browsersync;
exports.scripts = scripts;
exports.styles = styles;
exports.acfModuleStyles = acfModuleStyles;
exports.images = images;
exports.fonts = fonts;
// Use 'gulp' comand to run them all parallel.
exports.default = parallel(scripts, styles, acfModuleStyles,   images, fonts, browsersync, startwatch);
