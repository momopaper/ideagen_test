import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            zIndex: {
                9999: "9999",
            },
        },
    },

    variants: {
        extend: {
            backgroundColor: [
                "responsive",
                "hover",
                "focus",
                "active",
                "disabled",
            ],
            textColor: ["responsive", "hover", "focus", "group-hover"],
            borderColor: ["responsive", "hover", "focus"],
            opacity: ["responsive", "hover", "focus", "disabled"],
            cursor: ["responsive", "disabled"],
            space: ["responsive"],
            margin: ["responsive", "first", "last"],
            width: ["responsive"],
        },
    },

    safelist: [
        {
            pattern: /./,
        },
    ],

    plugins: [forms, typography],
};
