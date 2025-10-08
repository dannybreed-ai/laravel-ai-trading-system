import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/trading.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }
                    if (id.includes('resources/js/charts')) {
                        return 'charts';
                    }
                    if (id.includes('resources/js/utilities')) {
                        return 'utilities';
                    }
                },
            },
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
            '@components': '/resources/js/components',
            '@utils': '/resources/js/utilities',
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});