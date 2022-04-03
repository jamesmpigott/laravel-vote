module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    fontFamily: {
      'serif': ['Asar', 'ui-serif', 'Georgia' ],
      'sans': ['Raleway', 'ui-sans-serif', 'system-ui']
    },
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
