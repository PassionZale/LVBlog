var gulp = require("gulp");
var less = require("gulp-less");
var mincss = require("gulp-minify-css");

// copy files
gulp.task("copyfiles", function() {

    // jQuery
    gulp.src("vendor/bower_dl/jquery/dist/jquery.min.js")
        .pipe(gulp.dest("public/js/lib"));

    // bootstrap
    gulp.src("vendor/bower_dl/bootstrap/dist/css/bootstrap.min.css")
        .pipe(gulp.dest("public/css"));

    gulp.src("vendor/bower_dl/bootstrap/dist/js/bootstrap.min.js")
        .pipe(gulp.dest("public/js/lib"));

    gulp.src("vendor/bower_dl/bootstrap/dist/fonts/**")
        .pipe(gulp.dest("public/fonts"));

    // sweetalert
    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.css")
        .pipe(mincss())
        .pipe(gulp.dest("public/css"));

    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.min.js")
        .pipe(gulp.dest("public/js/lib"));

});

// mix less
gulp.task("mixless", function() {

    gulp.src("resources/assets/less/app.less")
        .pipe(less())
        .pipe(mincss())
        .pipe(gulp.dest("public/css/"));

});

// watch less
gulp.task("watchless", function() {
    // 当所有less文件改变时，执行mixless任务
    gulp.watch('resources/assets/less/*.less', ['mixless']);
});
