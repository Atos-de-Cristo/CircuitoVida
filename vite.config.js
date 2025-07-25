import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/buttons.css',
                'resources/css/font.css',
                'resources/js/app.js'
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Services/**',
                'app/Models/**',
                'routes/**'
            ],
        }),
    ],
});
