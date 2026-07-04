import axios from 'axios';
import { useAuthStore } from '../store/auth';
import { useUiStore } from '../store/ui';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api',
  timeout: 15000,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
});

api.interceptors.request.use((config) => {
  const authStore = useAuthStore();
  const uiStore = useUiStore();

  uiStore.startLoading();

  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`;
  }

  return config;
});

api.interceptors.response.use(
  (response) => {
    useUiStore().stopLoading();
    return response;
  },
  (error) => {
    const uiStore = useUiStore();
    const authStore = useAuthStore();

    uiStore.stopLoading();

    if (error.response?.status === 401) {
      authStore.logout();
    }

    const message = error.response?.data?.message || error.message || 'Something went wrong.';
    uiStore.notify({ type: 'error', message });

    return Promise.reject(error);
  }
);

export default api;
