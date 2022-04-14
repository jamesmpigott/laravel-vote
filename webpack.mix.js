const mix = require('laravel-mix');

const WebpackShellPluginNext = require('webpack-shell-plugin-next');

mix.webpackConfig({
    plugins:
    [
        new WebpackShellPluginNext({
            onBuildStart: {
                scripts: [
                    'php artisan lang:js -s lang --quiet'
                ]
            }
        })
    ]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);
