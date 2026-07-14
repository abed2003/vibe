<script setup>
defineProps({
  icon: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'ghost',
    validator: (value) => ['ghost', 'danger'].includes(value)
  },
  type: {
    type: String,
    default: 'button'
  }
});

defineEmits(['click']);
</script>

<template>
  <button
    class="icon-button"
    :class="`icon-button--${variant}`"
    :type="type"
    :aria-label="label"
    :title="label"
    @click="$emit('click', $event)"
  >
    <span class="material-symbols-outlined">{{ icon }}</span>
  </button>
</template>

<style scoped>
.icon-button {
  align-items: center;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: var(--radius-full);
  color: var(--on-surface-muted);
  cursor: pointer;
  display: inline-flex;
  height: 40px;
  justify-content: center;
  transition: color var(--duration-base) var(--ease-standard), border-color var(--duration-base) var(--ease-standard), background var(--duration-base) var(--ease-standard);
  width: 40px;
}

html.light .icon-button {
  background: rgba(20, 20, 30, 0.04);
  border-color: rgba(20, 20, 30, 0.12);
}

.icon-button--danger:hover {
  border-color: var(--error);
  color: var(--error);
}

.icon-button--ghost:hover {
  border-color: var(--primary-strong);
  color: var(--on-surface);
}
</style>
