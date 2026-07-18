<script setup>
import BottomNav from '../components/navigation/BottomNav.vue';

defineProps({
  immersive: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <div class="app-layout">
    <main class="page-shell" :class="{ 'page-shell--immersive': immersive }">
      <slot />
    </main>
    <BottomNav />
  </div>
</template>

<style scoped>
.app-layout {
  min-height: 100dvh;
}
</style>
