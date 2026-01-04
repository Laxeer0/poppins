/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./woocommerce/**/*.php",
    "./src/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          popred: "#FF2030",
          sand: "#F9E2B0",
          deep: "#003745",
          wine: "#770417",
          gold: "#F4BB47",
          teal: "#1F525E"
        }
      },
      fontFamily: {
        sans: ["Arial", "ui-sans-serif", "system-ui", "-apple-system", "sans-serif"],
        display: ["5TH AVENUE", "5th Avenue", "Arial Black", "Arial", "sans-serif"]
      },
      boxShadow: {
        hard: "6px 6px 0 #003745",
        strong: "10px 10px 0 #003745"
      },
      borderRadius: {
        xl: "20px"
      }
    }
  },
  plugins: []
};

