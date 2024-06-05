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
            fontFamily: {
                sans: ['Noto Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary : '#3F6836',
                primarySurface : '#BFEFB0',
                secondary : '#386569',
                surface: '#F8FBF1',
                onPrimary: '#FFFFFF',
                onSecondary: '#FFFFFF',
                onSurface: '#191D17',
                surfaceVariant: '#DFE4D8',
                onSurfaceVariant: '#43483F',
                error: '#BA1A1A',
                gastronomique : '#FF8484',
                nature : '#C5F7B6',
                art : '#E5DA73',
                musee : '#66CDC7',
                famille : '#F7B6ED',
                architecture : '#E8AB73',
                panorama : '#FFF59C',
                historique : '#FFB884',
                easy : '#A6CFA5',
                medium : '#AFC3E1',
                hard : '#DC6767',
                customGray : '#C3C8BC',
                outline : '#73796E',
            },
        },
    },

    plugins: [forms],

    darkMode: 'class',
};
