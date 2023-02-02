const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: "transparent",
                current: "currentColor",
                premier: "#B90027",
                sekunder: "#021942",
                tersier: "#5A595E",
                y_premier: "#6074B1",
                y_sekunder: "#60B0BF",
                y_tersier: "#CE55A1",
                y_kuartener: "#EF8E8D",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
