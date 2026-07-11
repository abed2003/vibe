<script setup>
const links = [
  { to: '/', icon: 'home', label: 'Home' },
  { to: '/explore', icon: 'explore', label: 'Explore' },
  { to: '/create', icon: 'add_circle', label: 'Create' },
  { to: '/search', icon: 'search', label: 'Search' },
  { to: '/profile', icon: 'person', label: 'Profile' }
];
</script>

<template>
  <nav class="bottom-nav glass" aria-label="Mobile navigation">
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

.bottom-nav__link.router-link-active .material-symbols-outlined {
  animation: nav-pulse 900ms ease-out;
  border-radius: 999px;
}

.bottom-nav__link .material-symbols-outlined {
  font-size: 23px;
  transition: transform 160ms ease;
}

.bottom-nav__link:active .material-symbols-outlined {
  transform: scale(0.88);
}

.bottom-nav__link--create {
  color: #fefaff;
  position: relative;
  top: -10px;
}

.bottom-nav__link--create .material-symbols-outlined {
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: 999px;
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
</style>
