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
            height: {
                '10p': '10%',
                '20p': '20%',
                '30p': '30%',
                '40p': '40%',
                '50p': '50%',
                '60p': '60%',
                '70p': '70%',
                '80p': '80%',
                '90p': '90%',
                '100p': '100%',
              },
              width: {
                '10p': '10%',
                '20p': '20%',
                '30p': '30%',
                '40p': '40%',
                '50p': '50%',
                '60p': '60%',
                '70p': '70%',
                '80p': '80%',
                '90p': '90%',
                '100p': '100%',
              }  
        },
    },

    plugins: [forms],
};
