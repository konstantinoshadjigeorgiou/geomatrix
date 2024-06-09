const sass = require("gulp-sass")(require("sass")),
  sourcemaps = require("gulp-sourcemaps"),
  cleanCSS = require("gulp-clean-css"),
  rename = require("gulp-rename"),
  autoprefixer = require("gulp-autoprefixer"),
  terser = require("gulp-terser");

const { src, dest, watch, series, parallel } = require("gulp");

const paths = {
  styles: "./assets/styles/**/*.scss",
  scripts: "./assets/scripts/**/*.js",
  images: "./assets/images/**/*",
  fonts: "./assets/fonts/**/*",
  libs: {
    all: "./assets/libs/**/*",
    scss: "./assets/libs/**/*.scss",
    notScss: "!./assets/libs/**/*.scss",
  },
  watch: {
    styles: "./assets/styles/**/*.scss",
    scripts: "./assets/scripts/**/*.js",
  },
  dist: {
    styles: "dist/styles",
    scripts: "dist/scripts",
    images: "dist/images",
    fonts: "dist/fonts",
    libs: "dist/libs",
  },
};

function stylesTask() {
  return src(paths.styles)
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(cleanCSS())
    .pipe(rename({ suffix: ".min" }))
    .pipe(sourcemaps.write("."))
    .pipe(dest(paths.dist.styles));
}

function scriptsTask() {
  return (
    src(paths.scripts)
      // .pipe(terser())
      .pipe(dest(paths.dist.scripts))
  );
}

// Move library assets to dist
function libsTask() {
  return src([paths.libs.all, paths.libs.notScss]).pipe(dest(paths.dist.libs));
}

function libsScssTask() {
  return src(paths.libs.scss)
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(dest(paths.dist.libs));
}

function fontsTask() {
  return src(paths.fonts).pipe(dest(paths.dist.fonts));
}

// Move images to dist
function imagesTask() {
  return src(paths.images).pipe(dest("./dist/images"));
}

function watchTask() {
  watch(paths.watch.styles, stylesTask);
  watch(paths.watch.scripts, scriptsTask);
  watch(paths.images, imagesTask);
  watch(paths.fonts, fontsTask);
  watch(paths.libs.all, libsTask);
  watch(paths.libs.scss, libsScssTask);
}

exports.styles = stylesTask;
exports.scripts = scriptsTask;
exports.watch = watchTask;
exports.fonts = fontsTask;
exports.images = imagesTask;
exports.libs = series(libsTask, libsScssTask);

exports.default = series(
  fontsTask,
  imagesTask,
  stylesTask,
  scriptsTask,
  libsScssTask,
  libsTask
);
