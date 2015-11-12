# install the base theme, underscores
request = require 'request'
fs      = require 'fs'
unzip   = require 'unzip'
meta    = require '../package.json'

options = {
    uri:  "http://underscores.me/"
    form:
        underscoresme_generate: 1
        underscoresme_name: meta.name
        underscoresme_slug: meta.name # this value should be equals to npm root folder
        underscoresme_author: meta.author.name
        underscoresme_author_uri: meta.author.url
        underscoresme_description: meta.description
        underscoresme_sass: true
    encoding: null #give a buffer on this request
}

dirs = __dirname.split '/'
dirs.pop()
rootName = dirs.pop()

if rootName isnt meta.name
    console.log 'Unsuitable root directory name.\nInstallation has been interrupted.'
    return

fs.stat '../style.css', (err, stats) ->
    if err # A theme may not exists
        request.post(options)
           .pipe unzip.Extract {path:'../'}
           .on 'close', ()->
                console.log 'Theme installation has been done.'
    else # A theme may be exists
        console.log 'A theme seems to exists and installation hasnot been done.'
