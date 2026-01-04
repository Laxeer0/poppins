/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./**/*.php', './woocommerce/**/*.php', './src/**/*.js'],
	theme: {
		extend: {
			colors: {
				ink: '#003745',
				accent: '#FF2030',
				soft: '#F9E2B0',
				secondary: '#1F525E',
			},
			fontFamily: {
				sans: ['Arial', 'ui-sans-serif', 'system-ui', 'sans-serif'],
				display: ['"5TH AVENUE"', 'Arial Black', 'Arial', 'sans-serif'],
			},
			borderRadius: {
				'2xl': '16px',
				xl: '14px',
			},
			boxShadow: {
				soft: '0 8px 24px rgba(0, 55, 69, 0.08)',
			},
		},
	},
	plugins: [],
};



