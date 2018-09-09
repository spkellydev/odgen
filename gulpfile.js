const gulp = require("gulp"),
  sass = require("gulp-sass"),
  rename = require("gulp-rename"),
  cssmin = require("gulp-cssnano"),
  prefix = require("gulp-autoprefixer"),
  plumber = require("gulp-plumber"),
  notify = require("gulp-notify"),
  sassLint = require("gulp-sass-lint"),
  path = require("path"),
  sassdoc = require("sassdoc"),
  babel = require("gulp-babel"),
  uglify = require("gulp-uglify"),
  sourcemaps = require("gulp-sourcemaps"),
  // Temporary solution until gulp 4
  // https://github.com/gulpjs/gulp/issues/355
  runSequence = require("run-sequence");

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
  browsers: [">1%"],
  grid: true
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

gulp.task("js", function() {
  return gulp
    .src("src/js/app.js")
    .pipe(
      babel({
        minified: true,
        comments: false,
        presets: [
          [
            "env",
            {
              targets: {
                browsers: ["last 8 versions"]
              }
            }
          ]
        ]
      })
    )
    .pipe(gulp.dest("public/assets/js"));
});

gulp.task("watch", function() {
  gulp.watch("src/scss/**/*.scss", ["styles", "sassdoc"]);
  gulp.watch("src/js/**/*.js", ["js"]);
});

// BUILD TASKS
// ------------

gulp.task("default", function(done) {
  runSequence("styles", "js", "watch", done);
});

gulp.task("build", function(done) {
  runSequence("styles", done);
});
