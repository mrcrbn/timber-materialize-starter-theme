var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync');

var browserSyncProxyUrl = "192.168.1.6:8000";


gulp.task('default', function(){

});
gulp.task('copy_bower_to_static', function(){

    //copy jquery to js folder
    gulp.src('./vendor/jquery/dist/jquery.min.js')
            .pipe(gulp.dest('./static/js/'));

    //*****************************************

    //copy fonts to fonts folder
    gulp.src(['./vendor/roboto-fontface/fonts/roboto/Roboto-Regular.woff',
        './vendor/roboto-fontface/fonts/roboto/Roboto-Regular.woff2'])
            .pipe(gulp.dest('./static/fonts/roboto/'));

    //*****************************************

    //copy materialize js to js folder
    gulp.src('./vendor/materialize/dist/js/materialize.min.js')
            .pipe(gulp.dest('./static/js/'));

});

gulp.task('sass', function(){
    return gulp.src('./scss/style.scss')
            .pipe(sass())
            .pipe(gulp.dest('./static/css'))

});

gulp.task('browserSync', function(){
    browserSync.init({
        proxy: browserSyncProxyUrl,
        ws: true,
        ghostMode: true
    })
});
gulp.task('bs-reload', function(){
    browserSync.reload();
});

gulp.task('watch', ['browserSync', 'sass'], function(){
    gulp.watch('scss/**/*.scss', ['sass', 'bs-reload']);
    gulp.watch('materialize-templates/**/*.twig', ['bs-reload']);
    gulp.watch('*.php', ['bs-reload']);

});
