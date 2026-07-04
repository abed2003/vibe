<template>
  <RouterLink class="brand-logo" to="/" aria-label="TikVibe home">
    <span class="brand-logo__mark material-symbols-outlined">play_circle</span>
    <span class="brand-logo__text brand-gradient">VIBE</span>
  </RouterLink>
</template>

<style scoped>
.brand-logo {
  align-items: center;
  display: inline-flex;
  gap: 8px;
}

.brand-logo__mark {
  color: var(--primary);
  font-size: 30px;
}

.brand-logo__text {
  font-size: 30px;
  font-weight: 800;
  line-height: 1;
}
</style>
