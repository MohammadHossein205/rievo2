import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        screens: {
            'xl': {'max': '1200px'},
            // => @media (max-width: 1279px) { ... }

            'lg': {'max': '1000px'},
            // => @media (max-width: 1023px) { ... }

            'md': {'max': '700px'},
            // => @media (max-width: 767px) { ... }

            'sm': {'max': '500px'},
            // => @media (max-width: 639px) { ... }
        },
        extend: {
            gridTemplateColumns: {
                'minmaxfill': 'repeat(auto-fill, minmax(12rem, 1fr))'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'modal': 'rgba(0, 0, 0, 0.7)'
            }
        },
    },

    plugins: [forms],
};
