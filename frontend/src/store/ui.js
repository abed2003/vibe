import { defineStore } from 'pinia';

let alertId = 0;

export const useUiStore = defineStore('ui', {
  state: () => ({
    loadingCount: 0,
    alerts: []
  }),
  getters: {
    isLoading: (state) => state.loadingCount > 0
  },
  actions: {
    startLoading() {
      this.loadingCount += 1;
    },
    stopLoading() {
      this.loadingCount = Math.max(0, this.loadingCount - 1);
    },
    notify({ type = 'info', message }) {
      const id = ++alertId;
      this.alerts.push({ id, type, message });
      window.setTimeout(() => this.dismiss(id), 4200);
    },
    dismiss(id) {
      this.alerts = this.alerts.filter((alert) => alert.id !== id);
    }
  }
});
