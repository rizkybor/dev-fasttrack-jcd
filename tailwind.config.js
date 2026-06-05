import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#9e1f16',
                secondary: '#1F2937',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                marquee: {
                    from: { transform: 'translateX(0)' },
                    to: { transform: 'translateX(-50%)' },
                },
                'marquee-reverse': {
                    from: { transform: 'translateX(-50%)' },
                    to: { transform: 'translateX(0)' },
                },
            },
            animation: {
                'marquee': 'marquee 45s linear infinite',
                'marquee-reverse': 'marquee-reverse 45s linear infinite',
            },
        },
    },

    plugins: [forms],
};
