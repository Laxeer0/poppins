module.exports = {
  content: [
    "./**/*.php",
    "./woocommerce/**/*.php",
    "./src/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        display: ['"5TH AVENUE"', '"Arial Black"', 'Arial', 'sans-serif'],
        sans: ['Arial', 'sans-serif']
      },
      colors: {
        popred: '#FF2030',
        popcream: '#F9E2B0',
        popnavy: '#003745',
        popwine: '#770417',
        popyellow: '#F4BB47',
        popteal: '#1F525E'
      },
      boxShadow: {
        hard: '10px 10px 0 0 rgba(0,55,69,0.35)'
      },
      borderWidth: {
        3: '3px'
      },
      borderRadius: {
        'xl2': '20px'
      }
    }
  },
  plugins: [
    require('autoprefixer')
  ]
};

