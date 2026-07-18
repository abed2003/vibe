<script setup>
import { ref, computed, watch, nextTick } from 'vue';
import { useFeedStore } from '../../store/feed';
import { useAuthStore } from '../../store/auth';
import { useUiStore } from '../../store/ui';
import { formatCount } from '../../services/videos';
import CommentItem from './CommentItem.vue';
import StateBlock from '../common/StateBlock.vue';

const props = defineProps({
  video: {
    type: Object,
    default: null
  }
});

const feedStore = useFeedStore();
const authStore = useAuthStore();
const uiStore = useUiStore();

const draft = ref('');
const inputEl = ref(null);
const submitting = ref(false);
const deletingId = ref(null);

const thread = computed(() => (props.video ? feedStore.commentsFor(props.video) : { list: [], loading: false, nextCursor: null }));
const engagement = computed(() => (props.video ? feedStore.stateFor(props.video) : null));

function close() {
  feedStore.closeComments();
}

async function submit() {
  const text = draft.value.trim();
  if (!text || !props.video || submitting.value) return;

  submitting.value = true;

  try {
    await feedStore.addComment(props.video, text);
    draft.value = '';
  } finally {
    submitting.value = false;
  }
}

async function removeComment(comment) {
  if (deletingId.value) return;
  deletingId.value = comment.id;

  try {
    await feedStore.removeComment(props.video, comment);
    uiStore.notify({ type: 'success', message: 'Comment deleted.' });
  } finally {
    deletingId.value = null;
  }
}

watch(
  () => props.video,
  async (video) => {
    if (!video) return;
    feedStore.loadComments(video, { reset: true });
    await nextTick();
    inputEl.value?.focus();
  }
);
</script>

<template>
  <Teleport to="body">
    <Transition name="sheet">
      <div v-if="video" class="comments-sheet" @keydown.esc="close">
        <div class="comments-sheet__backdrop" @click="close"></div>
        <section class="comments-sheet__panel" role="dialog" aria-modal="true" aria-label="Comments">
          <div class="comments-sheet__handle"></div>
          <header class="comments-sheet__header">
            <strong>{{ formatCount(engagement?.commentsCount ?? 0) }} comments</strong>
            <button type="button" aria-label="Close comments" @click="close">
              <span class="material-symbols-outlined">close</span>
            </button>
          </header>

          <div class="comments-sheet__list">
            <CommentItem
              v-for="comment in thread.list"
              :key="comment.id"
              :comment="comment"
              :deleting="deletingId === comment.id"
              @delete="removeComment"
            />

            <StateBlock v-if="thread.loading" loading compact message="Loading comments…" />
            <StateBlock v-else-if="!thread.list.length" compact icon="mode_comment" message="Be the first to comment." />

            <button
              v-if="thread.nextCursor && !thread.loading"
              type="button"
              class="comments-sheet__more"
              @click="feedStore.loadComments(video)"
            >
              Load more comments
            </button>
          </div>

          <form v-if="authStore.isAuthenticated" class="comments-sheet__composer" @submit.prevent="submit">
            <input ref="inputEl" v-model="draft" class="pill-input" type="text" placeholder="Add a comment..." maxlength="1000" />
            <button type="submit" aria-label="Post comment" :disabled="!draft.trim() || submitting">
              <span class="material-symbols-outlined">send</span>
            </button>
          </form>
          <div v-else class="comments-sheet__composer comments-sheet__composer--guest">
            <RouterLink class="app-button primary" :to="{ name: 'login', query: { redirect: $route.fullPath } }">
              Log in to join the conversation
            </RouterLink>
          </div>
        </section>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.comments-sheet {
  inset: 0;
  position: fixed;
  z-index: 200;
}

.comments-sheet__backdrop {
  background: rgba(5, 8, 12, 0.6);
  inset: 0;
  position: absolute;
}

.comments-sheet__panel {
  background: var(--surface-container);
  border-radius: var(--radius-xl) var(--radius-xl) 0 0;
  bottom: 0;
  box-shadow: 0 -18px 60px rgba(0, 0, 0, 0.45);
  display: grid;
  grid-template-rows: auto auto 1fr auto;
  left: 50%;
  max-height: 72dvh;
  max-width: 480px;
  position: absolute;
  transform: translateX(-50%);
  width: 100%;
}

.comments-sheet__handle {
  background: var(--outline-soft);
  border-radius: var(--radius-full);
  height: 4px;
  justify-self: center;
  margin-top: 10px;
  width: 40px;
}

.comments-sheet__header {
  align-items: center;
  display: flex;
  justify-content: space-between;
  padding: var(--space-3) var(--space-4);
}

.comments-sheet__header button {
  background: transparent;
  border: 0;
  color: var(--on-surface-muted);
  cursor: pointer;
  display: grid;
  padding: 4px;
  place-items: center;
}

.comments-sheet__list {
  display: grid;
  gap: var(--space-4);
  overflow-y: auto;
  padding: var(--space-2) var(--space-4) var(--space-4);
}

.comments-sheet__more {
  background: transparent;
  border: 1px solid var(--outline-soft);
  border-radius: var(--radius-full);
  color: var(--on-surface);
  cursor: pointer;
  font-weight: var(--weight-bold);
  justify-self: center;
  min-height: 38px;
  padding: 0 var(--space-4);
}

.comments-sheet__composer {
  border-top: 1px solid var(--outline-soft);
  display: flex;
  gap: var(--space-2);
  padding: var(--space-3) var(--space-4) calc(var(--space-3) + env(safe-area-inset-bottom));
}

.comments-sheet__composer--guest {
  justify-content: center;
}

.comments-sheet__composer button[type='submit'] {
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border: 0;
  border-radius: var(--radius-full);
  color: var(--on-vivid);
  cursor: pointer;
  display: grid;
  flex: none;
  height: 44px;
  place-items: center;
  width: 44px;
}

.comments-sheet__composer button[type='submit']:disabled {
  cursor: default;
  filter: grayscale(0.7);
  opacity: 0.5;
}

.sheet-enter-active,
.sheet-leave-active {
  transition: opacity var(--duration-moderate) var(--ease-standard);
}

.sheet-enter-active .comments-sheet__panel,
.sheet-leave-active .comments-sheet__panel {
  transition: transform var(--duration-moderate) var(--ease-out);
}

.sheet-enter-from,
.sheet-leave-to {
  opacity: 0;
}

.sheet-enter-from .comments-sheet__panel,
.sheet-leave-to .comments-sheet__panel {
  transform: translateX(-50%) translateY(100%);
}
</style>
