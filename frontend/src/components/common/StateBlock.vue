<script setup>
defineProps({
  icon: {
    type: String,
    default: ''
  },
  title: {
    type: String,
    default: ''
  },
  message: {
    type: String,
    default: ''
  },
  loading: {
    type: Boolean,
    default: false
  },
  compact: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <div class="state-block" :class="{ 'state-block--compact': compact }" role="status">
    <span v-if="loading" class="material-symbols-outlined loader">progress_activity</span>
    <span v-else-if="icon" class="material-symbols-outlined state-block__icon">{{ icon }}</span>
    <h2 v-if="title" class="state-block__title">{{ title }}</h2>
    <p v-if="message" class="state-block__message">{{ message }}</p>
    <div v-if="$slots.default" class="state-block__actions">
      <slot />
    </div>
  </div>
</template>

<style scoped>
.state-block {
  align-items: center;
  color: var(--on-surface-muted);
  display: grid;
  gap: var(--space-3);
  justify-content: center;
  justify-items: center;
  min-height: 40dvh;
  padding: var(--space-6);
  text-align: center;
}

.state-block--compact {
  min-height: 0;
  padding: var(--space-4);
}

.state-block--compact .loader,
.state-block--compact .state-block__icon {
  font-size: 28px;
}

.state-block__icon {
  font-size: 40px;
}

.state-block__title {
  color: var(--on-surface);
  font-size: var(--text-lg);
  margin: 0;
}

.state-block__message {
  margin: 0;
  max-width: 40ch;
}

.state-block__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
  justify-content: center;
}
</style>
