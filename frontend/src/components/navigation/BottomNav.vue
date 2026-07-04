<script setup>
const links = [
  { to: '/', icon: 'home', label: 'Home' },
  { to: '/explore', icon: 'explore', label: 'Explore' },
  { to: '/dashboard', icon: 'add_circle', label: 'Create' },
  { to: '/search', icon: 'search', label: 'Search' },
  { to: '/profile', icon: 'person', label: 'Profile' }
];
</script>

<template>
  <nav class="bottom-nav glass" aria-label="Mobile navigation">
    <RouterLink v-for="link in links" :key="link.to" :to="link.to" class="bottom-nav__link">
      <span class="material-symbols-outlined">{{ link.icon }}</span>
      <span>{{ link.label }}</span>
    </RouterLink>
  </nav>
</template>

<style scoped>
.bottom-nav {
  align-items: center;
  bottom: 14px;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  left: 50%;
  max-width: 430px;
  min-height: 64px;
  padding: 8px;
  position: fixed;
  transform: translateX(-50%);
  width: min(calc(100% - 28px), 430px);
  z-index: 90;
}

.bottom-nav__link {
  align-items: center;
  border-radius: 999px;
  color: var(--on-surface-muted);
  display: grid;
  font-size: 11px;
  font-weight: 700;
  gap: 2px;
  justify-items: center;
  min-height: 48px;
}

.bottom-nav__link.router-link-active {
  background: rgba(91, 94, 255, 0.24);
  color: var(--on-surface);
}

.bottom-nav__link .material-symbols-outlined {
  font-size: 23px;
}
</style>
