import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/reset.css',
                'resources/css/style.css',
                'resources/css/header.css',
                'resources/js/bootstrap.bundle.min.js',
                'resources/js/script.js'
            ],
            refresh: true,
        }),
    ],
});
