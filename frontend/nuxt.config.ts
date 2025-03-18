// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ["@nuxtjs/tailwindcss"],
  compatibilityDate: "2025-03-15",
  runtimeConfig: {
    public: {
      apiBase: process.env.API_BASE_URL || "http://127.0.0.1:8000/api", // URL da API Laravel
    },
  },
});
