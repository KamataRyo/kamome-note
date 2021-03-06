gulp     = require 'gulp'
plumber  = require 'gulp-plumber'
notify   = require 'gulp-notify'
rename   = require 'gulp-rename'

coffee   = require 'gulp-coffee'
concat   = require 'gulp-concat'
uglify   = require 'gulp-uglify'

compass  = require 'gulp-compass'
minify   = require 'gulp-minify-css'
rtlcss   = require 'gulp-rtlcss'

sort     = require 'gulp-sort'
wpPot    = require 'gulp-wp-pot'

gettext  = require 'gulp-gettext'

sketch   = require 'gulp-sketch'

meta     = require './package.json'

scopes = [
    'coffee/**/*.coffee'
    'sass/**/*.scss'
    '**/*.php'
    'languages/*.po'
    'sketch/**/*.sketch'
]
tasks = [
    'coffee'
    'compass'
    'wpPot'
    'gettext'
    #'sketchSS'
]

src =
    coffee:   'coffee/**/*.coffee'
    compass:  'sass/**/*.scss'
    wpPot:    '**/*.php'
    gettext:  'languages/*.po'
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
        .pipe rtlcss()
        .pipe rename suffix:'-rtl'
        .pipe gulp.dest './'


gulp.task 'wpPot', ()->
    gulp.src src['wpPot']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe sort()
        .pipe wpPot
            domain: meta.name
            destFile: "#{meta.name}.pot"
        .pipe gulp.dest './languages'


gulp.task 'gettext', ()->
    gulp.src src['gettext']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe gettext()
        .pipe gulp.dest '../../languages/themes/'


gulp.task 'sketchSS', ()->
    gulp.src src['sketchSS']
        .pipe plumber(errorHandler: notify.onError '<%= error.message %>')
        .pipe sketch
            export: 'artboards'
            formats: 'png'
        .pipe gulp.dest './'



gulp.task 'watch', ()->
    gulp.watch scopes, tasks

gulp.task 'default', tasks
gulp.task 'dev', tasks.concat('watch')
