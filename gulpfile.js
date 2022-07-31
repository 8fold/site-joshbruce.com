const gulp = require("gulp");
const rename = require("gulp-rename");

// const rawDestLocal   = "./site-raw/local";
// const rawDestPublic  = "./site-raw/public";
const rootDestLocal  = "./site-root/local";
const rootDestPublic = "./site-root/public";
// const loreDestLocal  = "./site-lore/local";
// const loreDestPublic = "./site-lore/public";

gulp.task("default", (done) => {
  console.log('gulp sass: Compiles the CSS');
  console.log('gulp javascript: Compiles the JavaScript');
	done();
});

/**
 * Begin Sass
 */
const sass = require("gulp-dart-scss");
const autoprefixer = require("autoprefixer");
const discardComments = require("postcss-discard-comments");
const csso = require("postcss-csso");
const sourcemaps = require("gulp-sourcemaps");
const postcss = require("gulp-postcss");

gulp.task("sass", (done) => {
  const src            = "./src/assets/sass/styles.scss";
  const pluginsProcess = [discardComments(), autoprefixer()];
  const pluginsMinify  = [csso({ forceMediaMerge: false })];

  gulp
    .src(src)
    .pipe(sourcemaps.init({ largeFile: true }))
    .pipe(
      sass({ outputStyle: "expanded" })
      .on("error", () => { console.log('ERROR: while compiling Sass') }))
    .pipe(postcss(pluginsProcess))
    // .pipe(gulp.dest(rawDestLocal + '/css'))
    // .pipe(gulp.dest(rawDestPublic + '/css'))
    .pipe(gulp.dest(rootDestLocal + '/css'))
    .pipe(gulp.dest(rootDestPublic + '/css'))
    // .pipe(gulp.dest(loreDestLocal + '/css'))
    // .pipe(gulp.dest(loreDestPublic + '/css'))
    .pipe(postcss(pluginsMinify))
    .pipe(rename({suffix: ".min"}))
    .pipe(sourcemaps.write("."))
    // .pipe(gulp.dest(rawDestLocal + '/css'))
    // .pipe(gulp.dest(rawDestPublic + '/css'))
    .pipe(gulp.dest(rootDestLocal + '/css'))
    .pipe(gulp.dest(rootDestPublic + '/css'));
    // .pipe(gulp.dest(loreDestLocal + '/css'))
    // .pipe(gulp.dest(loreDestPublic + '/css'));
  done();
});

/**
 * Begin javascript
 */
const uglify = require("gulp-uglify");

gulp.task("javascript", (done) => {
  const src = "./src/assets/js/interactive.js";

  gulp
    .src(src)
    .pipe(uglify())
    .pipe(rename({suffix: ".min"}))
    // .pipe(gulp.dest(rawDestLocal + '/js'))
    // .pipe(gulp.dest(rawDestPublic + '/js'))
    .pipe(gulp.dest(rootDestLocal + '/js'))
    .pipe(gulp.dest(rootDestPublic + '/js'));
    // .pipe(gulp.dest(loreDestLocal + '/js'))
    // .pipe(gulp.dest(loreDestPublic + '/js'));
  done();
});

/**
 * Begin favicons
 */
gulp.task("favicons", (done) => {
  const src = "./src/assets/favicons";

  gulp
    .src(src + '/**/*')
    // .pipe(gulp.dest(rawDestLocal + '/favicons'))
    // .pipe(gulp.dest(rawDestPublic + '/favicons'))
    .pipe(gulp.dest(rootDestLocal + '/favicons'))
    .pipe(gulp.dest(rootDestPublic + '/favicons'));
    // .pipe(gulp.dest(loreDestLocal + '/favicons'))
    // .pipe(gulp.dest(loreDestPublic + '/favicons'));
  done();
});

/**
 * Begin ui
 */
gulp.task("ui", (done) => {
  const src = "./src/assets/ui";

  gulp
    .src(src + "/**/*")
    // .pipe(gulp.dest(rawDestLocal + "/ui"))
    // .pipe(gulp.dest(rawDestPublic + '/ui'))
    .pipe(gulp.dest(rootDestLocal + '/ui'))
    .pipe(gulp.dest(rootDestPublic + '/ui'));
    // .pipe(gulp.dest(loreDestLocal + '/ui'))
    // .pipe(gulp.dest(loreDestPublic + '/ui'));
  done();
});

/**
 * Begin fonts
 */
// gulp.task("fonts", (done) => {
//   const src = "./src/assets/fonts";
//
//   gulp
//     .src(src + "/**/*")
//     // .pipe(gulp.dest(rawDestLocal + '/fonts'))
//     // .pipe(gulp.dest(rawDestPublic + '/fonts'))
//     // .pipe(gulp.dest(rootDestLocal + '/fonts'))
//     // .pipe(gulp.dest(rootDestPublic + '/fonts'))
//     // .pipe(gulp.dest(loreDestLocal + '/fonts'))
//     // .pipe(gulp.dest(loreDestPublic + '/fonts'));
//   done();
// });

gulp.task("watch", () => {
  gulp.watch("./src/assets/sass/**/*.scss", gulp.series("sass"));
  return;
});
