const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: false,
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0B2447",
                secondary: "#19376D",
                'input-bg': '#ffffff',
                'input-text': '#1f2937',
                'input-border': '#d1d5db',
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
