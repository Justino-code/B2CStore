import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '')

    const host = env.VITE_DEV_HOST || 'localhost'

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
        server: {
            host,
            port: 5173,
            strictPort: true,
            cors: true,
            hmr: {
                host,
                protocol: 'ws',
            },
            watch: {
                ignored: ['**/vendor/**', '**/node_modules/**'],
                usePolling: true,
            },
        },
    }
})
