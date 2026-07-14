<script setup>
import ThemeToggle from '../components/common/ThemeToggle.vue';
</script>

<template>
  <main class="auth-layout screen">
    <ThemeToggle class="auth-layout__theme-toggle" />
    <section class="auth-layout__panel">
      <slot />
    </section>
  </main>
</template>

<style scoped>
.auth-layout {
  align-items: center;
  display: flex;
  justify-content: center;
  overflow: hidden;
  padding: var(--space-6) var(--space-4);
  position: relative;
}

.auth-layout::before,
.auth-layout::after {
  border-radius: var(--radius-full);
  content: "";
  filter: blur(90px);
  height: 260px;
  opacity: 0.32;
  position: absolute;
  width: 260px;
}

html.light .auth-layout::before,
html.light .auth-layout::after {
  opacity: 0.16;
}

.auth-layout::before {
  background: var(--primary-strong);
  left: -80px;
  top: -60px;
}

.auth-layout::after {
  background: var(--tertiary);
  bottom: -80px;
  right: -70px;
}

.auth-layout__panel {
  max-width: 440px;
  position: relative;
  width: 100%;
  z-index: 1;
}

.auth-layout__theme-toggle {
  position: absolute;
  right: var(--space-4);
  top: var(--space-4);
  z-index: 2;
}
</style>
