import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/reset.css',
                'resources/css/upload.css',
                'resources/css/scrollbar.css',
                'resources/css/createAlbum.css',
                'resources/css/gallery.css',
                'resources/css/style.css',
                'resources/css/header.css',
                'resources/css/footer.css',
                'resources/css/modal.css',
                'resources/js/bootstrap.bundle.min.js',
                'resources/js/load-form.js',
                'resources/js/slider.js',
                'resources/js/theme-switch.js',
                'resources/js/Resource.js',
                'resources/js/downloadAlbum.js',
                'resources/js/gallery.js',
                'resources/js/tab.js',
                'resources/js/video-gallery.js',
                'resources/js/masonry.pkgd.js',
                'resources/js/upload.js',
                'resources/js/masonry.pkgd.min.js',
            ],
            refresh: true,
        }),
    ],
});
