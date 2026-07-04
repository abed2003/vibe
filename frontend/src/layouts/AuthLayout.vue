<template>
  <main class="auth-layout screen">
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
  padding: 24px 16px;
  position: relative;
}

.auth-layout::before,
.auth-layout::after {
  border-radius: 999px;
  content: "";
  filter: blur(90px);
  height: 260px;
  opacity: 0.32;
  position: absolute;
  width: 260px;
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
</style>
