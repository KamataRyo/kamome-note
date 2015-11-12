gulp     = require 'gulp'
plumber  = require 'gulp-plumber'
notify   = require 'gulp-notify'
mustache = require 'gulp-mustache'
coffee   = require 'gulp-coffee'
concat   = require 'gulp-concat'
uglify   = require 'gulp-uglify'
changed  = require 'gulp-changed'
sketch   = require 'gulp-sketch'

meta = 'package.json'
scopes = [
    'templates/mustache/**/*.*'
    meta
]
tasks = ['coffee', 'js','php', 'sketchSS']

src =
    coffee:   'templates/mustache/coffee/**/*.coffee'
    js:       'templates/mustache/js/**/*.js'
    php:      'templates/mustache/**/*.php'
    #pot:      'templates/mustache/languages/*.pot'
    sketchSS: 'templates/sketch/screenshot.sketch'

gulp.task 'coffee', ()->
    gulp.src src['coffee']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe mustache meta
        .pipe coffee { bare:false }
        .pipe concat 'index.min.js'
        .pipe uglify()
        .pipe gulp.dest './js/'

gulp.task 'js', ()->
    gulp.src src['js']
        #.pipe changed './'
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe mustache meta
        .pipe uglify()
        .pipe gulp.dest './js/'

gulp.task 'sketchSS', ()->
    gulp.src src['sketchSS']
        #.pipe changed './'
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe sketch
            export: 'artboards'
            formats: 'png'
        .pipe gulp.dest './'

gulp.task 'php', ()->
    gulp.src src['php']
        #.pipe changed './'
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe mustache meta
        .pipe gulp.dest './'

# gulp.task 'pot', ()->
#     gulp.src src['pot']
#         .pipe changed './languages/'


gulp.task 'watch', ()->
    gulp.watch scopes, tasks

gulp.task 'default', tasks.concat 'watch'
