const defaultTheme = require("tailwindcss/defaultTheme");
const plugin = require('tailwindcss/plugin');
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        // add custom variant for expanding sidebar
        plugin(({ addVariant, e }) => {
            addVariant("sidebar-expanded", ({ modifySelectors, separator }) => {
                modifySelectors(({ className }) => {
                    return `.sidebar-expanded .${e(
                        `sidebar-expanded${separator}${className}`
                    )}`;
                });
            });
        }),
    ],
};
