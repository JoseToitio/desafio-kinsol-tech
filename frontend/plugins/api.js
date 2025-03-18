export default defineNuxtPlugin(() => {
  const apiBase = useRuntimeConfig().public.apiBase;
  return {
    provide: {
      api: {
        get: (url) =>
          useFetch(`${apiBase}${url}`, {
            onResponseError( error ) {
              console.error("Erro na requisição POST:", error.response._data);
            },
          }),
        post: (url, body) =>
          $fetch(`${apiBase}${url}`, {
            method: "POST",
            body,
            onResponseError( error ) {
              console.error("Erro na requisição POST:", error.response._data);
            },
            headers: {
              Authorization: `Bearer ${localStorage.getItem(`token`)}`,
          },
          }),
        put: (url, body) =>
          $fetch(`${apiBase}${url}`, {
            method: "PUT",
            body,
            onResponseError( error ) {
              console.error("Erro na requisição POST:", error.response._data);
            },
            headers: {
              Authorization: `Bearer ${localStorage.getItem(`token`)}`,
          },
          }),
        delete: (url) =>
          $fetch(`${apiBase}${url}`, {
            method: "DELETE",
            onResponseError( error ) {
              console.error("Erro na requisição POST:", error.response._data);
            },
            headers: {
              Authorization: `Bearer ${localStorage.getItem(`token`)}`,
          },
          }),
      },
    },
  };
});