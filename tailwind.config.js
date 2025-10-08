/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1DA1F2',
        secondary: '#14171A',
        tradingGreen: '#4CAF50',
        tradingRed: '#F44336',
        tradingBlue: '#2196F3',
      },
      animation: {
        bounce: 'bounce 1s infinite',
        fade: 'fade 0.5s ease-in-out',
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
        jetBrains: ['JetBrains Mono', 'monospace'],
      },
      backgroundImage: {
        'gradient-trading': 'linear-gradient(to right, #1DA1F2, #4CAF50)',
      },
      boxShadow: {
        trading: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
  darkMode: 'class', // Enable dark mode support
};