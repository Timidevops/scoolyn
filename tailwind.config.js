module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {},
 
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
  ],
  colors: {

    'white': '#FFFFFF',
    'blue-100': '#020E83',
    'purple-100': '#EAECF4',
    'gray-100':'#707070',
    'gray-200': '#1F2438',
    'gray-300':'#8283A2',
    'gray-400':'#787389',
    'gray-500':'#78738933',
    

},
}
};
