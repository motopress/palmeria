/* global require */
var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var autoprefixer = require('gulp-autoprefixer');
var watch = require('gulp-watch');
var lec = require('gulp-line-ending-corrector');

/* Change your directory and settings here */
var settings = {
    publicDir: './',
    sassDir: './scss',
    cssDir: './',
    systemNotify: true, // change to disable system notification
    proxy: ''
}

/**
 * watch for changes in sass files
 */
gulp.task('serve', ['sass'], function () {
    gulp.watch("./sass/**/*.scss", ['sass']);
});

/**
 * sass task, will compile the .SCSS files,
 * and handle the error through plumber and notify through system message.
 */
gulp.task('sass', function () {
    return gulp.src('./sass/**/**/**/*.scss')
        .pipe(plumber({
            errorHandler: settings.systemNotify ? notify.onError("Error: <%= error.messageOriginal %>") : function (err) {
                console.log(" ************** \n " + err.messageOriginal + "\n ************** ");
                this.emit('end');
            }
        }))
        .pipe(sass({outputStyle: 'expanded'})) /* compressed */
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(lec({verbose:true, eolc: 'CRLF', encoding:'utf8'}))
        .pipe(gulp.dest('./'))
});

gulp.task('default', ['serve']);
gulp.task('build', ['sass']);
