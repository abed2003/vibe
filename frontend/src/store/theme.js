import { defineStore } from 'pinia';

const STORAGE_KEY = 'tikvibe.theme';
const THEME_COLORS = { dark: '#10141a', light: '#f7f7fb' };

function readStoredTheme() {
  try {
    return localStorage.getItem(STORAGE_KEY);
  } catch {
    return null;
  }
}

function prefersLight() {
  return window.matchMedia?.('(prefers-color-scheme: light)').matches ?? false;
}

function applyTheme(theme) {
  document.documentElement.className = theme;
  document.documentElement.style.colorScheme = theme;

  const meta = document.querySelector('meta[name="theme-color"]');
  if (meta) {
    meta.setAttribute('content', THEME_COLORS[theme]);
  }
}

export const useThemeStore = defineStore('theme', {
  state: () => ({
    theme: readStoredTheme() || (prefersLight() ? 'light' : 'dark')
  }),
  actions: {
    init() {
      applyTheme(this.theme);
    },
    setTheme(theme) {
      this.theme = theme;
      applyTheme(theme);
      try {
        localStorage.setItem(STORAGE_KEY, theme);
      } catch {
        // localStorage unavailable — theme still applies for this session
      }
    },
    toggleTheme() {
      this.setTheme(this.theme === 'dark' ? 'light' : 'dark');
    }
  }
});
