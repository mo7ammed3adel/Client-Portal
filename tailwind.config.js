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
                // Navy-blue brand identity (from the TOLBA / طلبة logo)
                brand: {
                    50: '#eef5fc',
                    100: '#d9e8f8',
                    200: '#b9d4f0',
                    300: '#8bb6e4',
                    400: '#5690d3',
                    500: '#316fbd',
                    600: '#1f56a0',
                    700: '#1c4582',
                    800: '#1b3c6c',
                    900: '#1a3458',
                    950: '#11213b',
                },
                // Orange call-to-action accent (the delivery van)
                accent: {
                    50: '#fff7ed',
                    100: '#ffedd3',
                    200: '#fed8a8',
                    300: '#fdbd72',
                    400: '#fb963a',
                    500: '#f97316',
                    600: '#e8650a',
                    700: '#c2530a',
                    800: '#9a4110',
                    900: '#7c3711',
                },
                ink: {
                    900: '#14233f',
                    800: '#1a2e4f',
                    700: '#213a61',
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
