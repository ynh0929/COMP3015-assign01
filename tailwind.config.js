/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./dist/*.{html,js,php}",
     './pages/*.{html,js,php}',
      './components/*.{html,js,php}',
      './src/*.{html,js,php}',
      './layout/*.{html,js,php}',
      './helpers/*.{html,js,php}',
      'index.php',
      './*.php',

  ],
  theme: {
    extend: {},
  },
  plugins: [
      require("daisyui"),
      require('@tailwindcss/forms'),
  ],
};
