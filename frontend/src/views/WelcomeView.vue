<template>
  <main class="welcome-view screen">
    <section class="welcome-view__media">
      <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=1200&q=80" alt="Creator performing under stage lights" />
      <div></div>
    </section>
    <section class="welcome-view__content">
      <h1 class="brand-gradient">VIBE</h1>
      <p>Watch, create, and save premium short-form video experiences.</p>
      <div class="welcome-view__actions">
        <RouterLink class="app-button primary" to="/register">Get started</RouterLink>
        <RouterLink class="app-button ghost" to="/login">Login</RouterLink>
      </div>
    </section>
  </main>
</template>

<style scoped>
.welcome-view {
  display: grid;
  overflow: hidden;
  place-items: end center;
  position: relative;
}

.welcome-view__media,
.welcome-view__media img,
.welcome-view__media div {
  inset: 0;
  position: absolute;
}

.welcome-view__media img {
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.welcome-view__media div {
  background: linear-gradient(to top, rgba(10, 14, 20, 0.96), rgba(10, 14, 20, 0.3), rgba(10, 14, 20, 0.08));
}

.welcome-view__content {
  display: grid;
  gap: var(--space-4);
  max-width: 520px;
  padding: var(--space-7) var(--space-4) 58px;
  position: relative;
  text-align: center;
  z-index: 1;
}

.welcome-view h1 {
  font-size: clamp(64px, 16vw, 112px);
  line-height: 0.9;
  margin: 0;
}

.welcome-view p {
  color: var(--on-vivid);
  font-size: var(--text-md);
  margin: 0;
  opacity: 0.82;
}

.welcome-view__actions {
  display: grid;
  gap: var(--space-2);
}
</style>
