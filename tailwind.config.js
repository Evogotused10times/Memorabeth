import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./resources/**/*.{vue,js,blade.php}'],
    theme: {
        extend: {
            colors: {
                primary: '#1E3A8A',
                secondary: {
                    light: '#F3F4F6',
                    dark: '#1F2937',
                },
                accent: '#FBBF24',
                error: '#EF4444',
                success: '#10B981',
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                display: ['Poppins', 'ui-sans-serif', 'system-ui'],
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-in-out',
                'scale-up': 'scaleUp 0.2s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                scaleUp: {
                    '0%': { transform: 'scale(0.95)' },
                    '100%': { transform: 'scale(1)' },
                },
            },
            boxShadow: {
                neumorphic: '8px 8px 16px rgba(0, 0, 0, 0.1), -8px -8px 16px rgba(255, 255, 255, 0.9)',
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [],
    darkMode: 'class', // Enable dark mode with class-based toggle
};
