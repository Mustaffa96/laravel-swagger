import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

/**
 * Vite Configuration for Laravel Swagger CRUD API
 * 
 * Optimized build configuration for modern web development.
 * Includes hot module replacement for development efficiency.
 */
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    // Build optimizations for production
    build: {
        // Generate source maps for debugging
        sourcemap: true,
        
        // Optimize chunk splitting for better caching
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['lodash'],
                },
            },
        },
        
        // Minification settings
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
    },
    
    // Development server configuration
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
