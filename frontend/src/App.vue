<script setup>
import { onMounted, onUnmounted } from 'vue';
import { RouterView } from 'vue-router';
import AlertStack from './components/common/AlertStack.vue';
import LoadingOverlay from './components/common/LoadingOverlay.vue';
import { useUiStore } from './store/ui';

const uiStore = useUiStore();

function handleOfflineReady() {
  uiStore.notify({
    type: 'success',
    message: 'TikVibe is ready for offline use.'
  });
}

function handleUpdateAvailable() {
  uiStore.notify({
    type: 'info',
    message: 'A fresh version is available. Reload when ready.'
  });
}

onMounted(() => {
  window.addEventListener('app:offline-ready', handleOfflineReady);
  window.addEventListener('app:update-available', handleUpdateAvailable);
});

onUnmounted(() => {
  window.removeEventListener('app:offline-ready', handleOfflineReady);
  window.removeEventListener('app:update-available', handleUpdateAvailable);
});
</script>

<template>
  <RouterView />
  <AlertStack />
  <LoadingOverlay />
</template>
