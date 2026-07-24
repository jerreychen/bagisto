/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1440px",
            },

            padding: {
                DEFAULT: "90px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                navyBlue: "#0052CC",
                lightOrange: "#F0F7FF",
                darkGreen: '#40994A',
                darkBlue: '#003D99',
                darkPink: '#F85156',
                techBlue: '#0066FF',
                techCyan: '#00C6FF',
                techDark: '#0A1628',
                techLight: '#F0F7FF',
            },

            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                dmserif: ["DM Serif Display", "serif"],
            },

            backgroundImage: {
                'tech-gradient': 'linear-gradient(135deg, #0066FF 0%, #00C6FF 100%)',
                'tech-gradient-dark': 'linear-gradient(135deg, #0A1628 0%, #0052CC 100%)',
                'tech-gradient-light': 'linear-gradient(135deg, #F0F7FF 0%, #FFFFFF 100%)',
            },

            boxShadow: {
                'tech': '0 4px 20px rgba(0, 102, 255, 0.15)',
                'tech-lg': '0 8px 30px rgba(0, 102, 255, 0.2)',
                'tech-glow': '0 0 15px rgba(0, 198, 255, 0.4)',
            },

            animation: {
                'tech-pulse': 'tech-pulse 2s ease-in-out infinite',
                'tech-float': 'tech-float 3s ease-in-out infinite',
            },

            keyframes: {
                'tech-pulse': {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
                'tech-float': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
            },
        }
    },

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        }
    ]
};
