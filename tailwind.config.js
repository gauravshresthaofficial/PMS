/** @type {import('tailwindcss').Config} */
module.exports = {
  tailwindConfig: './styles/tailwind.config.js',
  content: ['./dist/*.{html,js,php}'
  ,
  './dist/php/*.{html,js,php}',
  './dist/php/invoice/*.{html,js,php}'],
  theme: {
    extend: {
      colors: {
        'pms-dark':'#1E1E1E',
        'pms-purple':'#283342',
        'pms-green':'#01A768',
        'pms-white':'#F1F5F9',
        'pms-error':'#9c4150',
        'pms-success':'#407a4a',
        'pms-process':'#377084',
        'pms-green-light':'#2DD4BF'
      }
    },
  },
  plugins: [],
}

