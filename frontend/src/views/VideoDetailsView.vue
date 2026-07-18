<script setup>
import { ref, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import AppLayout from '../layouts/AppLayout.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import CommentItem from '../components/feed/CommentItem.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { fetchVideo, formatCount } from '../services/videos';
import { useFeedStore } from '../store/feed';
import { useAuthStore } from '../store/auth';

const route = useRoute();
const feedStore = useFeedStore();
const authStore = useAuthStore();

const video = ref(null);
const loading = ref(true);
const notFound = ref(false);

const engagement = computed(() => (video.value ? feedStore.stateFor(video.value) : null));
const thread = computed(() => (video.value ? feedStore.commentsFor(video.value) : { list: [], loading: false, nextCursor: null }));

const draft = ref('');
const submitting = ref(false);
const deletingId = ref(null);

async function load(uuid) {
  loading.value = true;
  notFound.value = false;
  video.value = null;

  try {
    video.value = await fetchVideo(uuid);
    feedStore.hydrate(video.value);
    feedStore.loadComments(video.value, { reset: true });
  } catch (error) {
    if (error.response?.status === 404 || error.response?.status === 403) {
      notFound.value = true;
    }
  } finally {
    loading.value = false;
  }
}

async function submit() {
  const text = draft.value.trim();
  if (!text || !video.value || submitting.value) return;

  submitting.value = true;

  try {
    await feedStore.addComment(video.value, text);
    draft.value = '';
  } finally {
    submitting.value = false;
  }
}

async function removeComment(comment) {
  if (deletingId.value) return;
  deletingId.value = comment.id;

  try {
    await feedStore.removeComment(video.value, comment);
  } finally {
    deletingId.value = null;
  }
}

watch(() => route.params.id, (id) => load(id), { immediate: true });
</script>

<template>
  <AppLayout>
    <StateBlock v-if="loading" loading message="Loading video…" />

    <StateBlock v-else-if="notFound" icon="visibility_off" title="Video unavailable" message="This video was removed, is private, or the link is wrong.">
      <RouterLink class="app-button primary" to="/">Back to the feed</RouterLink>
    </StateBlock>

    <section v-else-if="video" class="video-details">
      <VideoCard :video="video" :auto-observe="false" />
      <aside class="video-details__panel glass">
        <h1>{{ video.title }}</h1>
        <p>{{ video.caption }}</p>
        <div class="video-details__stats">
          <span>{{ formatCount(engagement.likesCount) }} likes</span>
          <span>{{ formatCount(engagement.commentsCount) }} comments</span>
          <span>{{ formatCount(video.views) }} views</span>
        </div>

        <h2 id="comments">Comments</h2>
        <div class="video-details__comments">
          <CommentItem
            v-for="comment in thread.list"
            :key="comment.id"
            :comment="comment"
            :deleting="deletingId === comment.id"
            @delete="removeComment"
          />
          <StateBlock v-if="thread.loading" loading compact message="Loading comments…" />
          <p v-else-if="!thread.list.length" class="muted">Be the first to comment.</p>
          <button
            v-if="thread.nextCursor && !thread.loading"
            type="button"
            class="video-details__more"
            @click="feedStore.loadComments(video)"
          >
            Load more comments
          </button>
        </div>

        <form v-if="authStore.isAuthenticated" class="video-details__composer" @submit.prevent="submit">
          <input v-model="draft" class="pill-input" type="text" placeholder="Add a comment..." maxlength="1000" />
          <button class="app-button primary" type="submit" :disabled="!draft.trim() || submitting">Post</button>
        </form>
        <RouterLink
          v-else
          class="app-button ghost"
          :to="{ name: 'login', query: { redirect: route.fullPath } }"
        >
          Log in to comment
        </RouterLink>
      </aside>
    </section>
  </AppLayout>
</template>

<style scoped>
.video-details {
  display: grid;
  gap: var(--space-4);
  margin: 0 auto;
  max-width: 980px;
}

.video-details__panel {
  border-radius: var(--radius-xl);
  display: grid;
  gap: var(--space-3);
  align-content: start;
  padding: var(--space-6);
}

.video-details__panel h1,
.video-details__panel h2,
.video-details__panel p {
  margin: 0;
}

.video-details__stats {
  color: var(--on-surface-muted);
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
  font-weight: var(--weight-black);
}

.video-details__comments {
  display: grid;
  gap: var(--space-4);
}

.video-details__more {
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

.video-details__composer {
  display: flex;
  gap: var(--space-2);
}

.video-details__composer button:disabled {
  cursor: default;
  filter: grayscale(0.7);
  opacity: 0.5;
}

@media (min-width: 860px) {
  .video-details {
    grid-template-columns: minmax(300px, 430px) 1fr;
    align-items: start;
  }
}
</style>
