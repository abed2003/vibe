<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const overlay = computed(() => route.name === 'home');

const links = [
  { to: '/', icon: 'home', label: 'Home' },
  { to: '/explore', icon: 'explore', label: 'Explore' },
  { to: '/create', icon: 'add_circle', label: 'Create' },
  { to: '/search', icon: 'search', label: 'Search' },
  { to: '/profile', icon: 'person', label: 'Profile' }
];
</script>

<template>
  <nav class="bottom-nav glass" :class="{ 'bottom-nav--overlay': overlay }" aria-label="Mobile navigation">
    <RouterLink
      v-for="link in links"
      :key="link.to"
      :to="link.to"
      class="bottom-nav__link"
      :class="{ 'bottom-nav__link--create': link.to === '/create' }"
    >
      <span class="material-symbols-outlined">{{ link.icon }}</span>
      <span class="bottom-nav__label">{{ link.label }}</span>
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
  padding: var(--space-2);
  position: fixed;
  transform: translateX(-50%);
  width: min(calc(100% - 28px), 430px);
  z-index: 90;
}

.bottom-nav__link {
  align-items: center;
  border-radius: var(--radius-full);
  color: var(--on-surface-muted);
  display: grid;
  font-size: var(--text-2xs);
  font-weight: var(--weight-bold);
  gap: 2px;
  justify-items: center;
  min-height: 48px;
}

.bottom-nav__link.router-link-active {
  background: rgba(91, 94, 255, 0.24);
  color: var(--on-surface);
}

.bottom-nav__link.router-link-active .material-symbols-outlined {
  animation: nav-pulse var(--duration-decorative) ease-out;
  border-radius: var(--radius-full);
}

.bottom-nav__link .material-symbols-outlined {
  font-size: 23px;
  transition: transform var(--duration-base) var(--ease-standard);
}

.bottom-nav__link:active .material-symbols-outlined {
  transform: scale(0.88);
}

.bottom-nav__link--create {
  color: var(--on-vivid);
  position: relative;
  top: -10px;
}

.bottom-nav__link--create .material-symbols-outlined {
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: var(--radius-full);
  box-shadow: 0 10px 24px rgba(91, 94, 255, 0.4);
  font-size: 28px;
  padding: 10px;
}

.bottom-nav__link--create .bottom-nav__label {
  color: var(--on-surface-muted);
}

.bottom-nav__link--create.router-link-active {
  background: transparent;
}

.bottom-nav--overlay {
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
  background: transparent;
  border-color: transparent;
  bottom: 0;
  box-shadow: none;
}

.bottom-nav--overlay .bottom-nav__link {
  color: rgba(255, 255, 255, 0.72);
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.65);
}

.bottom-nav--overlay .bottom-nav__link.router-link-active {
  background: transparent;
  color: var(--on-vivid);
}

.bottom-nav--overlay .bottom-nav__link--create {
  color: var(--on-vivid);
}
</style>
