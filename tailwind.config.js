module.exports = {
  mode: "jit",
  purge: ["./view/*.php"],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      FontFamily: {},
    },
  },
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/typography"), require("@tailwindcss/forms")],
};
