<script setup>
import AppTopBar from '../components/navigation/AppTopBar.vue';
import BottomNav from '../components/navigation/BottomNav.vue';
</script>

<template>
  <div class="app-layout">
    <AppTopBar />
    <main class="page-shell">
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
