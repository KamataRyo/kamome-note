# kamome-note
This is a WordPress theme developmental environment generation.

## features
- based on [underscores](http://underscores.me/)
- gulp based developmental environment
    - CoffeeScript compiling
    - uglify JavaScript
    - Compass (scss)
    - CSS minify
    - pot file generation
    - sketch
- bower for front-end libraries

## requires
- CoffeeScript to run `gulpfile.coffee` and `setup/install.coffee`

## Installation
1. Clone this branch, `development_base`.

    `git clone -b development_base git@github.com:KamataRyo/kamome-note.git your-theme-slug`

2. Edit `package.json`. Examples are below and these values will be applied to underscores. `name` value *must* be equal to `your-slug-name`.

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

3. Set the cloned package up. `setup/install.coffee` runs at postinstall and install underscores.

    `npm install`
