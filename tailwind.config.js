const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    safelist: [
        'w-screen',
        'h-screen',
        'opacity-100',
        'w-0',
        'h-0',
        'opacity-0',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: "transparent",
                black: {
                    500: "#4F5665",
                    600: "#0B132A",
                },
                white: {
                    DEFAULT: "#fff",
                    300: "#F8F8F8",
                    500: "#fff",
                },
                primary: {
                    DEFAULT: '#DD2B47',
                    hover: '#e0213c',
                    100: '#da7788',
                    50: '#e8bcc3',
                },
            },
            borderWidth: {
                '3': '3px',
            }
        },
        boxShadow: {
            sm: "0 1px 2px 0 rgba(0, 0, 0, 0.05)",
            DEFAULT: "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
            md: "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
            lg: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
            xl: "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
            t: "0 -1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
            strong: "0px 18px 20px -15px rgba(0,0,0,0.25)",
            primary: "0px 18px 20px -15px rgba(221,43,71,0.81)",
            "orange-md": "0px 20px 40px -15px rgba(245,56,56,0.81)",
            none: "none",
        },
    },

    plugins: [require("daisyui")],

    daisyui: {
        themes: ['light'],
        styled: true,
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        prefix: '',
        darkTheme: 'light',
    },

    variants: {
        extend: {
            boxShadow: ["active", "hover"],
        },
    },
};
