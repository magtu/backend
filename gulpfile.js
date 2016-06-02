
/**
 * Require dependencies.
 */

var gulp = require('gulp')
var concat = require('gulp-concat')
var uglify = require('gulp-uglify')
var less = require('gulp-less')
var csso = require('gulp-csso')
var autoprefixer = require('gulp-autoprefixer')
var rename = require('gulp-rename')

/**
 * Project assets.
 */

var paths = {
    javascript: [
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/select2/dist/js/select2.min.js',
        //'bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js',
        //'bower_components/owl.carousel/dist/owl.carousel.js',
        'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
        'assets/javascript/Global.js',
        'assets/javascript/Main.js'
    ],
    less: [
        'assets/less/application.less'
    ],
    stylesheets: [
        'bower_components/select2/dist/css/select2.css'
        //'bower_components/owl.carousel/src/css/*.css'
    ]
};

/**
 * Build javascript.
 */

gulp.task('javascript', function() {
    return gulp.src(paths.javascript)
        .pipe(concat('javascript-build.js'))
        .pipe(gulp.dest('build/js'));
});

/**
 * Build less styles.
 */

gulp.task('less', function() {
    return gulp.src(paths.less)
        .pipe(less())
        .pipe(concat('less-build.css'))
        .pipe(gulp.dest('build/css'));
});

/**
 * Build stylesheets.
 */

gulp.task('stylesheets', function() {
    return gulp.src(paths.stylesheets)
        .pipe(concat('stylesheets-build.css'))
        .pipe(gulp.dest('build/css'));
});

/**
 * Build distribution.
 */

gulp.task('dist', ['javascript', 'less', 'stylesheets'], function() {
    gulp.src(['build/css/stylesheets-build.css', 'build/css/less-build.css'])
        //.pipe(autoprefixer({browsers: ['last 10 versions'],cascade: false}))
        //.pipe(csso())
        .pipe(concat('template_styles.css'))
        .pipe(gulp.dest('./public/css'));

    return gulp.src('build/js/javascript-build.js')
        .pipe(rename('scripts.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

/**
 * The default task (called when you run `gulp` from cli)
 */

gulp.task('default', ['dist']);