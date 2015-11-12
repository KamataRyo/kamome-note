gulp     = require 'gulp'
plumber  = require 'gulp-plumber'
notify   = require 'gulp-notify'

coffee   = require 'gulp-coffee'
concat   = require 'gulp-concat'
uglify   = require 'gulp-uglify'

compass  = require 'gulp-compass'
minify   = require 'gulp-minify-css'

changed  = require 'gulp-changed'

sketch   = require 'gulp-sketch'



scopes = [
    'coffee/**/*.coffee'
    'sass/**/*.scss'
    'sketch/**/*.sketch'
]
tasks = ['coffee', 'compass', 'sketchSS']

src =
    coffee:   'coffee/**/*.coffee'
    compass:  'sass/**/*.sass'
    pot:      'languages/*.pot'
    sketchSS: 'sketch/screenshot.sketch'

gulp.task 'coffee', ()->
    gulp.src src['coffee']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe coffee { bare:false }
        .pipe concat 'index.min.js'
        .pipe uglify()
        .pipe gulp.dest './js/'


gulp.task 'compass', ()->
    gulp.src src['compass']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe compass
            config_file: './config.rb',
            css: './',
            sass: 'sass'
        .pipe minify()
        .pipe gulp.dest './'


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
