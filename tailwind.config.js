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
            colors: {
                surface: '#f8fafc',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f1f5f9',
                'surface-container': '#e2e8f0',
                'surface-container-high': '#cbd5e1',
                'surface-container-highest': '#334155',
                primary: '#172033',
                'on-primary': '#ffffff',
                secondary: '#b45309',
                'secondary-fixed': '#fef3c7',
                'on-secondary': '#ffffff',
                'on-surface': '#172033',
                'on-surface-variant': '#475569',
                outline: '#64748b',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
