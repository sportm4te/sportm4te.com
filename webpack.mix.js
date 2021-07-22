const mix = require('laravel-mix');

require('laravel-mix-polyfill');

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
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/styles', 'public/styles')
    .copy('resources/styles/highlights', 'public/styles/highlights')
    .copy('resources/scripts', 'public/scripts')
    .copy('resources/fonts', 'public/fonts')
    .copy('resources/images', 'public/images')
    .copy('resources/images/sport', 'public/images/sport')

    .polyfill({
        enabled: true,
        useBuiltIns: "entry",
        targets: "> 0.25%, not dead",
        entryPoints: "all"
    })
    
if (!mix.inProduction()) {
    mix.sourceMaps()
        .webpackConfig({devtool: 'inline-source-map'});
}


if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}
