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
    "./resources/js/**/*.vue",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        blueberry: {
          50: "#F7F8FF",
          100: "#D1D6FC",
          200: "#ABB3FA",
          300: "#8591F7",
          400: "#626FE9",
          500: "#5561CB",
          600: "#4953AE",
          700: "#3D4591",
          800: "#303773",
          900: "#242956",
          950: "#181B38",
        },
      },
    },
  },

  plugins: [forms, typography],
};
