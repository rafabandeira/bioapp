import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],

    // ADICIONE ISTO: Força o VITE a incluir as classes de cor do IMC
    safelist: [
        'text-blue-600',
        'text-green-600',
        'text-yellow-600',
        'text-orange-600',
        'text-red-600',
    ]
};