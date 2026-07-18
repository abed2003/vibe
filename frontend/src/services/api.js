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

  // Lightweight background calls (likes, pagination, comments) opt out of the
  // global loading overlay via `silent: true` so the feed stays fluid.
  if (!config.silent) {
    uiStore.startLoading();
  }

  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`;
  }

  return config;
});

const FRIENDLY_MESSAGES = {
  400: 'The request was not valid. Please check your input.',
  401: 'Your session has expired. Please log in again.',
  403: 'You do not have permission to perform this action.',
  404: 'The requested content could not be found.',
  409: 'This action conflicts with the current state. Refresh and try again.',
  413: 'That file is too large to upload.',
  429: 'Too many requests. Please wait a moment and try again.',
  500: 'Something went wrong on the server. Please try again later.'
};

function isSilent(config) {
  return Boolean(config?.silent);
}

api.interceptors.response.use(
  (response) => {
    if (!isSilent(response.config)) {
      useUiStore().stopLoading();
    }
    return response;
  },
  (error) => {
    const uiStore = useUiStore();
    const authStore = useAuthStore();

    if (!isSilent(error.config)) {
      uiStore.stopLoading();
    }

    const status = error.response?.status;

    if (status === 401) {
      // Token rejected (expired/revoked) — drop the local session without
      // calling the API again (which would just 401 a second time).
      authStore.logout({ remote: false });
    }

    if (status === 422) {
      // Validation errors are rendered inline next to their fields by forms,
      // so they are attached to the error instead of toasted.
      error.validationErrors = error.response?.data?.errors || {};
    } else if (!error.__notified) {
      const message = status
        ? FRIENDLY_MESSAGES[status] ||
          (status < 500 ? error.response?.data?.message : null) ||
          FRIENDLY_MESSAGES[500]
        : 'Network error — please check your connection and try again.';

      uiStore.notify({ type: 'error', message });
      error.__notified = true;
    }

    return Promise.reject(error);
  }
);

export default api;
