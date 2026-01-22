import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                brand: {
                    primary: '#2563EB', // Biru Utama
                    soft: '#60A5FA',    // Biru Soft
                    neutral: '#E5E7EB', // Abu Netral
                    cta: '#22C55E',     // Hijau CTA
                },
            },
        },
    },

    plugins: [forms],
};
