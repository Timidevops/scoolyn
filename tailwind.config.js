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
    'red-100':'#EC4F4F',
    'green-100':'#037481',
    'gray-100':'#707070',
    'gray-200': '#1F2438',
    'gray-300':'#8283A2',
    'gray-400':'#F7F7FA',
    'gray-500':'#787389',
    'gray-600':'#78738933',
},
}
};
