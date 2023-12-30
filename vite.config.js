import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/css/app.css',
                // SCSS
                'resources/scss/components.scss',
                'resources/scss/page/home.scss',

                //JS
                'resources/js/app.js',
                'resources/js/function_interface.js',
            ],
            refresh: true,
        }),
    ],
});
