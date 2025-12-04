import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            // Ignora pastas pesadas para não criar watchers desnecessários
            ignored: ['**/vendor/**', '**/node_modules/**'],
            // Usa polling caso o limite de watchers seja atingido
            usePolling: true,
        },
    },
});

