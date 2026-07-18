import { defineStore } from 'pinia';
import { loginRequest, registerRequest, fetchCurrentUser, logoutRequest } from '../services/auth';

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
    async refreshUser() {
      if (!this.token) return;
      this.user = await fetchCurrentUser();
      this.persist();
    },
    async logout({ remote = true } = {}) {
      if (remote && this.token) {
        // Best effort: the session is cleared locally regardless of whether
        // the server-side token revocation succeeds.
        try {
          await logoutRequest();
        } catch {
          /* token may already be invalid — local logout proceeds anyway */
        }
      }

      this.token = null;
      this.user = null;
      this.initialized = true;
      localStorage.removeItem(STORAGE_KEY);
    }
  }
});
