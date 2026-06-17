import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Tajawal', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Teal brand identity (Bosta-style)
                brand: {
                    50: '#ecfdfd',
                    100: '#d0f7f8',
                    200: '#a6edf0',
                    300: '#6fdde3',
                    400: '#34c6cf',
                    500: '#14abb5',
                    600: '#0e8b95',
                    700: '#126f78',
                    800: '#155a62',
                    900: '#164a53',
                    950: '#062f35',
                },
                // Coral / red call-to-action accent
                accent: {
                    50: '#fff1f1',
                    100: '#ffe0e0',
                    200: '#ffc6c6',
                    300: '#ff9f9f',
                    400: '#ff6b6b',
                    500: '#f63d3d',
                    600: '#e42525',
                    700: '#c01b1b',
                    800: '#9e1a1a',
                    900: '#831b1b',
                },
                ink: {
                    900: '#0a2233',
                    800: '#0f2c41',
                    700: '#16384f',
                },
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-14px)' },
                },
                'float-slow': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-22px)' },
                },
                drive: {
                    '0%': { transform: 'translateX(-6%)' },
                    '50%': { transform: 'translateX(6%)' },
                    '100%': { transform: 'translateX(-6%)' },
                },
                'spin-slow': {
                    '0%': { transform: 'rotate(0deg)' },
                    '100%': { transform: 'rotate(360deg)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            animation: {
                'fade-up': 'fade-up 0.7s ease-out both',
                'fade-in': 'fade-in 0.8s ease-out both',
                float: 'float 4s ease-in-out infinite',
                'float-slow': 'float-slow 6s ease-in-out infinite',
                drive: 'drive 5s ease-in-out infinite',
                'spin-slow': 'spin-slow 8s linear infinite',
                marquee: 'marquee 28s linear infinite',
            },
        },
    },

    plugins: [forms],
};
