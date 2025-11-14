import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#FFE6D4',
                    100: '#FFD9C0',
                    200: '#FFC69D',
                    300: '#FFB389',
                    400: '#E06B80',
                    500: '#CD2C58',
                    600: '#B02449',
                    700: '#931C3A',
                    800: '#76152C',
                    900: '#590E1D',
                },
            },
        },
    },
    plugins: [],
};
