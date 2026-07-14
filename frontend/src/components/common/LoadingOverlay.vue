<script setup>
import { useUiStore } from '../../store/ui';

const uiStore = useUiStore();
</script>

<template>
  <div v-if="uiStore.isLoading" class="loading-overlay" aria-label="Loading">
    <span class="loading-overlay__spinner"></span>
  </div>
</template>

<style scoped>
.loading-overlay {
  align-items: center;
  background: var(--scrim-soft);
  display: flex;
  inset: 0;
  justify-content: center;
  pointer-events: none;
  position: fixed;
  z-index: 180;
}

.loading-overlay__spinner {
  animation: spin 700ms linear infinite;
  border: 3px solid rgba(255, 255, 255, 0.22);
  border-radius: var(--radius-full);
  border-top-color: var(--accent-vivid);
  height: 34px;
  width: 34px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
