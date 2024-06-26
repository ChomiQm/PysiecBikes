import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/register.scss',
                'resources/sass/admin_dashboard.scss',
            ],
            refresh: true,
        }),
    ],
});
