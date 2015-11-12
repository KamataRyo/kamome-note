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

fs.open './style.css', 'ax+',,(err, fd) ->
    if !err
        # theme exists
        console.log 'Theme seems to exists. The installation hasnot been done.'
        return
    else
        # thme not exists, override
        request.post(options)
            .pipe unzip.Extract {path:'../'}
            .on 'close', ()->
                console.log 'Theme installation has been done.'
