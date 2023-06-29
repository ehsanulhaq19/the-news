export const RequestInterceptor = [
    (config) => {
      config.headers.Accept = "application/json";
      const token = localStorage.getItem("token");
      // If token is present add it to request's Authorization Header
      if (token) {
        config.headers.Authorization = `Bearer ${token ? token : null}`;
      }
      return config;
    },
    (error) => Promise.reject(error),
];
  