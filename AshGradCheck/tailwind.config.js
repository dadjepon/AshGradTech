/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    "./node_modules/flowbite/**/*.js",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
],
  theme: {
    extend: {},
  },
  
  fontFamily: {
      sans: ['Inter var', ...defaultTheme.fontFamily.sans],
    },
  plugins: [
    require('flowbite/plugin')
  ],
}

