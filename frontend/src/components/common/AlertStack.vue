<script setup>
import { useUiStore } from '../../store/ui';

const uiStore = useUiStore();
</script>

<template>
  <div v-if="uiStore.alerts.length" class="alert-stack" aria-live="polite">
    <button
      v-for="alert in uiStore.alerts"
      :key="alert.id"
      class="alert-stack__item glass"
      :class="`alert-stack__item--${alert.type}`"
      type="button"
      @click="uiStore.dismiss(alert.id)"
    >
      <span class="material-symbols-outlined">
        {{ alert.type === 'error' ? 'error' : alert.type === 'success' ? 'check_circle' : 'info' }}
      </span>
      <span>{{ alert.message }}</span>
    </button>
  </div>
</template>

<style scoped>
.alert-stack {
  display: grid;
  gap: var(--space-2);
  position: fixed;
  right: var(--space-4);
  top: var(--space-4);
  width: min(360px, calc(100vw - 32px));
  z-index: 200;
}

.alert-stack__item {
  align-items: center;
  color: var(--on-surface);
  cursor: pointer;
  display: flex;
  gap: var(--space-2);
  padding: var(--space-3) var(--space-3);
  text-align: left;
}

.alert-stack__item--error {
  border-color: rgba(255, 180, 171, 0.42);
}

.alert-stack__item--success {
  border-color: rgba(131, 230, 161, 0.42);
}
</style>
