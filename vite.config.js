import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/images/bg-football.jpeg', 'resources/images/player.png', 'resources/images/default-profile.png'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
