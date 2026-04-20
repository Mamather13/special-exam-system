import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // <--- MUST HAVE THIS

export default defineConfig({
    plugins: [
        tailwindcss(), // <--- ADD THIS LINE
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});