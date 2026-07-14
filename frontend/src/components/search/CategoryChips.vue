<script setup>
defineProps({
  categories: {
    type: Array,
    required: true
  },
  active: {
    type: String,
    required: true
  }
});

defineEmits(['update:active']);
</script>

<template>
  <div class="chips" role="list" aria-label="Categories">
    <button
      v-for="category in categories"
      :key="category"
      class="chips__item"
      :class="{ 'chips__item--active': active === category }"
      type="button"
      @click="$emit('update:active', category)"
    >
      {{ category }}
    </button>
  </div>
</template>

<style scoped>
.chips {
  display: flex;
  gap: var(--space-2);
  overflow-x: auto;
  padding-bottom: 4px;
  scrollbar-width: none;
}

.chips::-webkit-scrollbar {
  display: none;
}

.chips__item {
  background: var(--surface-container);
  border: 1px solid var(--outline-soft);
  border-radius: var(--radius-full);
  color: var(--on-surface-muted);
  cursor: pointer;
  flex: 0 0 auto;
  font-weight: var(--weight-black);
  min-height: 38px;
  padding: 0 var(--space-4);
  transition: background var(--duration-base) var(--ease-standard), color var(--duration-base) var(--ease-standard), border-color var(--duration-base) var(--ease-standard);
}

.chips__item--active {
  background: var(--primary-strong);
  border-color: var(--primary-strong);
  color: var(--on-vivid);
}
</style>
