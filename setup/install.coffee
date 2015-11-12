# install the base theme, underscores
request    = require 'request'
fs         = require 'fs'
unzip      = require 'unzip'
parameters = require '../setup/parameters.json'


options = {
    uri:  parameters.action
    form: parameters.queries
    encoding: null #give a buffer on this request
}

request.post(options)
    .pipe unzip.Extract {path:'./'}
    .on 'close', ()->
        console.log 'Theme installation has been done.'
