request = require 'request'
fs      = require 'fs'
unzip   = require 'unzip'
meta    = require '../package.json'
options = {
    uri:  "http://underscores.me/"
    form:
        underscoresme_generate: 1
        underscoresme_name: meta.name
        underscoresme_slug: meta.name
        underscoresme_author: meta.author.name
        underscoresme_author_uri: meta.author.url
        underscoresme_description: meta.description
        underscoresme_sass: true
    encoding: null #give a buffer on this request
}


# get root directory name
dirArray = __dirname.split '/'
dirArray.pop()
rootName = dirArray.pop()


if rootName isnt meta.name
    console.log 'Unsuitable root directory name.\nInstallation has been interrupted.'
    return


fs.stat '../style.css', (err, stats) ->
    if err
        if err.code is 'ENOENT'
            # No theme exists.
            request.post(options)
                .pipe unzip.Extract path: '../'
                .on 'close', ()->
                    console.log 'Theme installation has been successed.'
        else
            #unknown error
            console.log "Some other error. err.code: #{err.code}"
    else
        # Another theme may exist.
        console.log 'A theme seems to exist.\nInstallation has been interrupted.'
