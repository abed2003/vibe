<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import BrandLogo from '../components/common/BrandLogo.vue';

const router = useRouter();

onMounted(() => {
  window.setTimeout(() => {
    router.push({ name: 'welcome' });
  }, 1200);
});
</script>

<template>
  <main class="splash-view screen">
    <BrandLogo />
    <span class="splash-view__pulse"></span>
  </main>
</template>

<style scoped>
.splash-view {
  align-items: center;
  display: grid;
  gap: 26px;
  justify-items: center;
}

.splash-view__pulse {
  animation: pulse 1s ease-in-out infinite;
  background: var(--primary);
  border-radius: var(--radius-full);
  height: 10px;
  width: 10px;
}

@keyframes pulse {
  50% {
    box-shadow: 0 0 0 14px rgba(192, 193, 255, 0.08);
    transform: scale(1.2);
  }
}
</style>
