<script setup>
defineProps({
  comment: {
    type: Object,
    required: true
  },
  deleting: {
    type: Boolean,
    default: false
  }
});

defineEmits(['delete']);
</script>

<template>
  <article class="comment-item">
    <img v-if="comment.avatar" :src="comment.avatar" :alt="comment.author" />
    <span v-else class="comment-item__initial">{{ comment.author.charAt(0) }}</span>
    <div class="comment-item__body">
      <strong>{{ comment.author }}<em v-if="comment.mine"> · you</em></strong>
      <p>{{ comment.text }}</p>
      <span class="comment-item__time">{{ comment.timeAgo }}</span>
    </div>
    <button
      v-if="comment.mine"
      type="button"
      class="comment-item__delete"
      :disabled="deleting"
      :aria-label="`Delete comment by ${comment.author}`"
      @click="$emit('delete', comment)"
    >
      <span class="material-symbols-outlined">delete</span>
    </button>
  </article>
</template>

<style scoped>
.comment-item {
  align-items: start;
  display: flex;
  gap: var(--space-3);
}

.comment-item img,
.comment-item__initial {
  border-radius: var(--radius-full);
  flex: none;
  height: 36px;
  width: 36px;
}

.comment-item__initial {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  color: var(--on-vivid);
  display: inline-flex;
  font-weight: var(--weight-black);
  justify-content: center;
}

.comment-item__body {
  display: grid;
  flex: 1;
  gap: 2px;
  min-width: 0;
}

.comment-item__body strong {
  color: var(--on-surface-muted);
  font-size: var(--text-xs);
}

.comment-item__body strong em {
  color: var(--primary);
  font-style: normal;
}

.comment-item__body p {
  margin: 0;
  overflow-wrap: anywhere;
}

.comment-item__time {
  color: var(--on-surface-muted);
  font-size: var(--text-2xs);
}

.comment-item__delete {
  background: transparent;
  border: 0;
  color: var(--on-surface-muted);
  cursor: pointer;
  padding: 4px;
  transition: color var(--duration-base) var(--ease-standard);
}

.comment-item__delete:hover {
  color: var(--error);
}

.comment-item__delete:disabled {
  cursor: default;
  opacity: 0.5;
}

.comment-item__delete .material-symbols-outlined {
  font-size: 18px;
}
</style>
