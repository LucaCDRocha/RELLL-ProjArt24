import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

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
                primary: '#3F6836',
                primarySurface: '#BFEFB0',
                secondary: '#386569',
                surface: '#F8FBF1',
                onPrimary: '#FFFFFF',
                onSecondary: '#FFFFFF',
                onSurface: '#191D17',
                surfaceVariant: '#DFE4D8',
                onSurfaceVariant: '#43483F',
                error: '#BA1A1A',

                gastronomique: '#FF8484',
                nature: '#C0FAAE',
                art: '#E5DA73',
                musee: '#95F1EB',
                famille: '#FACEF3',
                architecture: '#7BA9EE',
                panorama: '#D696FE',
                historique: '#FFB884',

                easy: '#A6CFA5',
                medium: '#AFC3E1',
                hard: '#DC6767',

                customGray: '#C3C8BC',
                outline: '#73796E',

                // Dark mode
                darkPrimary: '#6CD44E',
                darkPrimarySurface: '#9ADA88',
                darkSecondary: '#A0CFD2',
                darkSurface: '#11140F',
                darkOnPrimary: '#10380C',
                darkOnSecondary: '#10380C',
                darkOnSurface: '#F0F1ED',
                darkSurfaceVariant: '#43483F',
                darkOnSurfaceVariant: '#F0F1ED',
                darkError: '#FFB4AB',
                darkCustomGray: '#CAC4D0',
            },
        },
    },

    plugins: [forms],

    darkMode: 'class',
}
