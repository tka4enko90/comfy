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

/**
 * ! IMPORTANT - Change value to your local domain name.
 */
const baseDir = 'http://comfy.lvh.me';

// BrowserSync initialization.
function browsersync() {
	browserSync.init({
		proxy: baseDir,	// Use local domain directory as base.
		notify: false,	// Remove browser pop-up nitification.
		online: true	// Enable external address.
	})
}

// Process scripts.
function scripts() {
	return src(['src/js/main.js'])	// Get app.js file to process it.
		.pipe(rigger())					// For js includes inside file.
		.pipe(concat('main.min.js'))	// Conact in one file main.min.js.
		.pipe(uglify())					// Process.
		.pipe(dest('static/js/'))		// Output.
		.pipe(browserSync.stream())		// Trigger browserSync.
}

// Process styles (SCSS).
function styles() {
	return src(['src/scss/main.scss'])									// Get only main.scss file (you must add all includes inside it).
		.pipe(sourcemaps.init({loadMaps: true}))							// Initialize source maps and load existing.
		.pipe(sass())														// Process.
		.pipe(concat('main.min.css'))										// Concat in one file main.min.css.
		.pipe(autoprefixer({overrideBrowserslist: ['last 10 versions']}))	// Add prefixes.
		.pipe(cleancss(({level: {1: {specialComments: 0}}})))				// One-line minify.
		.pipe(sourcemaps.write())											// Write source maps.
		.pipe(dest('static/css/'))											// Output.
		.pipe(browserSync.stream())											// Trigger browserSync.
}

function acfModuleStyles() {
	return src(['modules/*/*.scss'])
		.pipe(sass()) // Process.
		.pipe(autoprefixer({overrideBrowserslist: ['last 10 versions']}))	// Add prefixes.
		.pipe(cleancss(({level: {1: {specialComments: 0}}})))				// One-line minify.
		.pipe(dest('static/css/modules/'))
		.pipe(browserSync.stream())
}

function acfModuleScripts() {
	return src(['modules/*/*.js'])
		.pipe(rigger())
		.pipe(uglify())
		.pipe(dest('static/js/modules/'))
		.pipe(browserSync.stream())
}

function pageTemplatesStyles() {
	return src(['src/scss/page-templates/*.scss'])
		.pipe(sass()) // Process.
		.pipe(autoprefixer({overrideBrowserslist: ['last 10 versions']}))	// Add prefixes.
		.pipe(cleancss(({level: {1: {specialComments: 0}}})))				// One-line minify.
		.pipe(dest('static/css/page-templates/'))
		.pipe(browserSync.stream())
}

function templatePartsStyles() {
	return src(['template-parts/flexible-sections/*/*.scss'])
		.pipe(sass()) // Process.
		.pipe(autoprefixer({overrideBrowserslist: ['last 10 versions']}))	// Add prefixes.
		.pipe(cleancss(({level: {1: {specialComments: 0}}})))				// One-line minify.
		.pipe(dest('static/css/template-parts/flexible-sections/'))
		.pipe(browserSync.stream())
}

function templatePartsScripts() {
	return src(['template-parts/flexible-sections/*/*.js'])
		.pipe(rigger())
		.pipe(uglify())
		.pipe(dest('static/js/template-parts/flexible-sections/'))
		.pipe(browserSync.stream())
}

// Minify images.
function images() {
	return src('src/img/**/*')	// Get all files from app/img/src/ directory.
		.pipe(newer('static/img'))	// Only new images (not in destination directory).
		.pipe(imagemin())			// Minimize images.
		.pipe(dest('static/img/'))	// Output.
}

//Fonts
function fonts() {
	return src('src/fonts/**/*')
		.pipe(dest('static/fonts/'))
}

// Watch all necessary files.
function startwatch() {
	watch('src/scss/**/*', styles);
	watch('modules/*/*.scss', acfModuleStyles);
	watch('modules/*/*.js', acfModuleScripts);
	watch('src/scss/page-templates/*.scss', pageTemplatesStyles);
	watch('template-parts/flexible-sections/*/*.scss', templatePartsStyles);
	watch('template-parts/flexible-sections/*/*.js', templatePartsScripts);
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
exports.acfModuleScripts = acfModuleScripts;
exports.pageTemplatesStyles = pageTemplatesStyles;
exports.templatePartsStyles = templatePartsStyles;
exports.templatePartsScripts = templatePartsScripts;
exports.images = images;
exports.fonts = fonts;
// Use 'gulp' comand to run them all parallel.
exports.default = parallel(scripts, styles, acfModuleStyles, acfModuleScripts, pageTemplatesStyles, templatePartsStyles, templatePartsScripts, images, fonts, browsersync, startwatch);
