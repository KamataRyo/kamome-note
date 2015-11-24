[![Build Status](https://travis-ci.org/KamataRyo/kamome-note.svg?branch=master)](https://travis-ci.org/KamataRyo/kamome-note)

# kamome-note
This is a WordPress theme developmental environment generation.

## features
- based on [underscores](http://underscores.me/)
- with a gulpfile

## requires
- CoffeeScript to run `gulpfile.coffee` and `setup/install.coffee`

## Installation
1. `git clone -b development_base git@github.com:KamataRyo/kamome-note.git your-theme-slug`

    Clone the `development_base` branch of this repo.

2. `vi package.json`

    Edit the metafile `package.json` as you like, but `name` value of the package *must* be equal to `your-theme-slug`.

    ```json
    {
        "name": "your-theme-slug",
        "description": "Your theme description.",
        "author": {
            "name": "your-name",
            "url": "http://your-url.example.com/"
        }
    }
    ```

3. `npm install`

    Set the cloned package up. The script `setup/install.coffee` runs at post-install and downloads the underscores theme.

4. Do anything.

    ex. edit gulp files as you like.
>>>>>>> development_base
