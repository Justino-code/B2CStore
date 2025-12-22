import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const host = import.meta.env.VITE_DEV_HOST || 'localhost';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: host,
        port: 5173,
        strictPort: true,
        cors: true,

        hmr: {
            host: host,
            protocol: 'ws'
        },
        
        watch: {
            // Ignora pastas pesadas para não criar watchers desnecessários
            ignored: ['**/vendor/**', '**/node_modules/**'],
            // Usa polling caso o limite de watchers seja atingido
            usePolling: true,
        },
    },
});

