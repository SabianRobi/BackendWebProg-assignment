import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //Styles
                'resources/css/app.css',
                'resources/css/dorang.css',

                //Scripts
                'resources/js/app.js',
                'resources/js/createLabel.js'
            ],
            refresh: true,
        }),
    ],
});
