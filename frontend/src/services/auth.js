import api from './api';

function normalizeSession(data) {
  return {
    token: data.token || data.access_token,
    user: data.user
  };
}

export async function loginRequest(credentials) {
  const { data } = await api.post('/auth/login', credentials);
  return normalizeSession(data);
}

export async function registerRequest(payload) {
  const { data } = await api.post('/auth/register', payload);
  return normalizeSession(data);
}

export async function fetchCurrentUser() {
  const { data } = await api.get('/auth/me');
  return data.user || data;
}

export async function logoutRequest() {
  await api.post('/auth/logout');
}
