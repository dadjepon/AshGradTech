/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
export default {
  content: [
    './resources/**/*.blade.php',
    '.components/**/*.{js,ts,jsx,tsx}',
    './resources/**/*.js',
    './resources/**/*.vue',
    "./node_modules/flowbite/**/*.js",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
],
  theme: {
    extend: {},
    colors: {
      backgroundColor: "#FCE7DA",
      hoverColor: "#AA767C",
      black: "#000000",
      white: "#FFFFFF",
      green: "#1DBC82",
      red: "#D34053",
      antiquewhite: "#fce7da",
      inputColor: "#FFEEE3",
      adminNavbarColor: "#FFEEE3",
      adminBackgroundColor:"#FFF4ED",
    },
  },
  
  fontFamily: {
      sans: ['Inter var', ...defaultTheme.fontFamily.sans],
    },
  plugins: [
    require('flowbite/plugin')
  ],
}

