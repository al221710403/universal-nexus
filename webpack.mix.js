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
// Copiea los archivos base
mix.copy('public/boxicons.json', 'storage/app/public');
mix.copy('public/img/noimg.png', 'storage/app/public');
mix.copy('public/img/noimg.png', 'storage/app/public/publish/post/image');


// Copia el CSS y JS de Tagify a la carpeta public
mix.copy('node_modules/@yaireo/tagify/dist/tagify.css', 'public/plugins/tagify/tagify.css');
mix.copy('node_modules/@yaireo/tagify/dist/tagify.js', 'public/plugins/tagify/tagify.js');
mix.copy('node_modules/@yaireo/tagify/dist/tagify.polyfills.min.js', 'public/plugins/tagify/tagify.polyfills.min.js');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css');

// Compila los estilos de CkEditor
mix.postCss('resources/plugins/ckeditor/ckeditor_base.css', 'public/plugins/ckeditor')
    .postCss('resources/plugins/ckeditor/ckeditor_create.css', 'public/plugins/ckeditor')
    .postCss('resources/plugins/ckeditor/ckeditor_view.css', 'public/plugins/ckeditor');

// Compila los estilos de Prism
mix.js('resources/plugins/prism/prism.js', 'public/plugins/prism')
    .postCss('resources/plugins/prism/prism.css', 'public/plugins/prism')
