var gulp = require("gulp"),
  sass = require("gulp-sass"),
  rename = require("gulp-rename"),
  cssmin = require("gulp-cssnano"),
  prefix = require("gulp-autoprefixer"),
  plumber = require("gulp-plumber"),
  notify = require("gulp-notify"),
  sassLint = require("gulp-sass-lint"),
  path = require("path"),
  sassdoc = require("sassdoc"),
  sourcemaps = require("gulp-sourcemaps");
// Temporary solution until gulp 4
// https://github.com/gulpjs/gulp/issues/355
runSequence = require("run-sequence");

var displayError = function(error) {
  // Initial building up of the error
  var errorString = "[" + error.plugin.error.bold + "]";
  errorString += " " + error.message.replace("\n", ""); // Removes new line at the end

  // If the error contains the filename or line number add it to the string
  if (error.fileName) errorString += " in " + error.fileName;

  if (error.lineNumber) errorString += " on line " + error.lineNumber.bold;

  // This will output an error like the following:
  // [gulp-sass] error message in file_name on line 1
  console.error(errorString);
};

var onError = function(err) {
  notify.onError({
    title: "Gulp",
    subtitle: "Failure!",
    message: "Error: <%= error.message %>",
    sound: "Basso"
  })(err);
  this.emit("end");
};

var sassOptions = {
  outputStyle: "expanded",
  includePaths: ["node_modules/mini.css/src"]
};

var prefixerOptions = {
  browsers: ["last 2 versions"]
};

// BUILD SUBTASKS
// ---------------

gulp.task("styles", function() {
  return gulp
    .src("src/scss/main.scss")
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sourcemaps.init())
    .pipe(sass(sassOptions))
    .pipe(prefix(prefixerOptions))
    .pipe(
      rename(function(file) {
        file.fileName = path.fileName;
        file.extname = ".css";
      })
    )
    .pipe(cssmin())
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest("./public/assets/css"));
});

gulp.task("sass-lint", function() {
  gulp
    .src("src/scss/**/*.scss")
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
});

gulp.task("sassdoc", function() {
  var options = {
    dest: "docs",
    verbose: true,
    display: {
      access: ["public", "private"],
      alias: true,
      watermark: true
    },
    groups: {
      undefined: "Ungrouped"
    },
    basePath: "https://github.com/SassDoc/sassdoc"
  };

  return gulp.src("src/scss/**/*.scss").pipe(sassdoc(options));
});

gulp.task("watch", function() {
  gulp.watch("src/scss/**/*.scss", ["styles", "sassdoc"]);
});

// BUILD TASKS
// ------------

gulp.task("default", function(done) {
  runSequence("styles", "watch", done);
});

gulp.task("build", function(done) {
  runSequence("styles", done);
});
