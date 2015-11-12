gulp     = require 'gulp'
plumber  = require 'gulp-plumber'
notify   = require 'gulp-notify'
coffee   = require 'gulp-coffee'
concat   = require 'gulp-concat'
uglify   = require 'gulp-uglify'
changed  = require 'gulp-changed'
sketch   = require 'gulp-sketch'

scopes = [
    'templates/mustache/**/*.*'
]
tasks = ['coffee', 'js','php', 'sketchSS']

src =
    coffee:   'coffee/**/*.coffee'
    pot:      'languages/*.pot'
    sketchSS: 'sketch/screenshot.sketch'

gulp.task 'coffee', ()->
    gulp.src src['coffee']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe coffee { bare:false }
        .pipe concat 'index.min.js'
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


# gulp.task 'pot', ()->
#     gulp.src src['pot']
#         .pipe changed './languages/'


gulp.task 'watch', ()->
    gulp.watch scopes, tasks

gulp.task 'default', tasks.concat('watch')
