import { defineStore } from 'pinia';
import { loginRequest, registerRequest, fetchCurrentUser } from '../services/auth';

const STORAGE_KEY = 'tikvibe.auth';

function readStoredAuth() {
  try {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
  } catch {
    return {};
  }
}

export const useAuthStore = defineStore('auth', {
  state: () => {
    const stored = readStoredAuth();

    return {
      token: stored.token || null,
      user: stored.user || null,
      initialized: false
    };
  },
  getters: {
    isAuthenticated: (state) => Boolean(state.token)
  },
  actions: {
    persist() {
      localStorage.setItem(
        STORAGE_KEY,
        JSON.stringify({
          token: this.token,
          user: this.user
        })
      );
    },
    setSession({ token, user }) {
      this.token = token;
      this.user = user;
      this.persist();
    },
    async login(credentials) {
      const session = await loginRequest(credentials);
      this.setSession(session);
      return session;
    },
    async register(payload) {
      const session = await registerRequest(payload);
      this.setSession(session);
      return session;
    },
    async hydrateUser() {
      if (!this.token || this.user) {
        this.initialized = true;
        return;
      }

      try {
        this.user = await fetchCurrentUser();
        this.persist();
      } finally {
        this.initialized = true;
      }
    },
    logout() {
      this.token = null;
      this.user = null;
      this.initialized = true;
      localStorage.removeItem(STORAGE_KEY);
    }
  }
});
