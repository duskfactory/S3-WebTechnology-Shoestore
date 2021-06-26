import { fontFamily as _fontFamily } from 'tailwindcss/defaultTheme';

export const purge = [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
];
export const theme = {
    extend: {
        fontFamily: {
            sans: ['Nunito', ..._fontFamily.sans],
        },
    },
};
export const variants = {
    extend: {
        opacity: ['disabled'],
    },
};
export const plugins = [require('@tailwindcss/forms')];
