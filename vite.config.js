import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/charts/patient-charts.js',
                'resources/js/charts/dashboard-charts.js', 
            ],
            refresh: true,
        }),
    ],
});