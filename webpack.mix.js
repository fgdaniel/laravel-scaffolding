const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/frontend/js/app.js', 'public/frontend/js')
    .postCss('resources/frontend/css/app.css', 'public/frontend/css', [
        require('postcss-import'),
        require('tailwindcss')({
			config: './resources/frontend/js/tailwind.config.js'
		}),
        require('postcss-nested'),
        require('postcss-custom-properties'),
        require('autoprefixer'),
    ])
	.js('resources/dashboard/js/app.js', 'public/dashboard/js')
    .postCss('resources/dashboard/css/app.css', 'public/dashboard/css', [
        require('postcss-import'),
        require('tailwindcss')({
			config: './resources/dashboard/js/tailwind.config.js'
		}),
        require('postcss-nested'),
        require('postcss-custom-properties'),
        require('autoprefixer'),
    ]);

if (mix.inProduction()) {
	mix.version();
}
