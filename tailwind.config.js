/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'select',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                accent: {
                    1: "hsl(var(--color-accent1) / <alpha-value>)",
                    2: "hsl(var(--color-accent2) / <alpha-value>)",
                },
                bkg: "hsl(var(--color-bkg) / <alpha-value>)",
                content: "hsl(var(--color-content) / <alpha-value>)"
            },
            animation: {
              "spin-slower": "spin 35s infinite",
              "spin-slow": "spin 25s ease-in-out infinite reverse",
            },
        },
    },
    plugins: [],
}

