<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import UploadVideoForm from '../components/video/UploadVideoForm.vue';
import { useUiStore } from '../store/ui';
import { useAuthStore } from '../store/auth';
import { useVideosStore } from '../store/videos';
import { fetchUserVideos } from '../services/users';
import { deleteVideo, timeAgo, formatCount } from '../services/videos';

const isFormOpen = ref(false);
const uiStore = useUiStore();
const authStore = useAuthStore();
const videosStore = useVideosStore();

const uploads = ref([]);
const loadingUploads = ref(true);
const deletingId = ref(null);

async function loadUploads() {
  loadingUploads.value = true;

  try {
    const page = await fetchUserVideos(authStore.user.id);
    uploads.value = page.videos;
  } finally {
    loadingUploads.value = false;
  }
}

function onUploaded(video) {
  isFormOpen.value = false;
  uiStore.notify({
    type: 'success',
    message: `“${video.title}” uploaded — it appears in the feed as soon as processing finishes.`
  });
  loadUploads();
}

async function remove(video) {
  if (deletingId.value) return;
  if (!window.confirm(`Delete “${video.title}”? This cannot be undone.`)) return;

  deletingId.value = video.id;

  try {
    await deleteVideo(video.id);
    uploads.value = uploads.value.filter((item) => item.id !== video.id);
    uiStore.notify({ type: 'success', message: 'Video deleted.' });
  } finally {
    deletingId.value = null;
  }
}

onMounted(loadUploads);
</script>

<template>
  <AppLayout>
    <section class="page-stack create-view">
      <div class="create-view__hero glass">
        <div>
          <p class="create-view__eyebrow">Creator Studio</p>
          <h1>Create and upload video</h1>
          <p class="muted">Tap the create button to open the upload form below.</p>
        </div>
        <button class="app-button primary create-view__button" type="button" @click="isFormOpen = !isFormOpen">
          <span class="material-symbols-outlined">{{ isFormOpen ? 'keyboard_arrow_up' : 'add_circle' }}</span>
          {{ isFormOpen ? 'Hide form' : 'Create video' }}
        </button>
      </div>

      <Transition name="form-pop">
        <UploadVideoForm v-if="isFormOpen" @cancel="isFormOpen = false" @uploaded="onUploaded" />
      </Transition>

      <section class="create-view__drafts">
        <div class="section-title">
          <h2>My uploads</h2>
          <span class="count-pill">{{ uploads.length }}</span>
        </div>
        <p v-if="loadingUploads" class="muted">Loading your uploads…</p>
        <article v-else-if="!uploads.length" class="empty-card glass">
          <span class="material-symbols-outlined">video_library</span>
          <p>No uploads yet. Publish your first video above.</p>
        </article>
        <article v-for="video in uploads" v-else :key="video.id" class="create-view__draft glass">
          <div>
            <strong>{{ video.title }}</strong>
            <p>
              <span class="status-chip" :data-status="video.status">{{ video.status }}</span>
              · {{ video.visibility }} · {{ formatCount(video.views) }} views · {{ timeAgo(video.publishedAt || '') || 'just now' }}
            </p>
          </div>
          <button type="button" aria-label="Delete video" :disabled="deletingId === video.id" @click="remove(video)">
            <span class="material-symbols-outlined">delete</span>
          </button>
        </article>
      </section>

      <section class="create-view__drafts">
        <div class="section-title">
          <h2>Drafts</h2>
          <span class="count-pill">{{ videosStore.drafts.length }}</span>
        </div>
        <article v-if="!videosStore.drafts.length" class="empty-card glass">
          <span class="material-symbols-outlined">draft</span>
          <p>No video drafts yet.</p>
        </article>
        <article v-for="draft in videosStore.drafts" :key="draft.id" class="create-view__draft glass">
          <div>
            <strong>{{ draft.title }}</strong>
            <p>{{ draft.fileName }} · {{ draft.visibility }}</p>
          </div>
          <button type="button" aria-label="Remove draft" @click="videosStore.removeDraft(draft.id)">
            <span class="material-symbols-outlined">delete</span>
          </button>
        </article>
      </section>
    </section>
  </AppLayout>
</template>

<style scoped>
.create-view {
  display: grid;
  gap: var(--space-4);
  margin: 0 auto;
  max-width: 760px;
}

.create-view__hero {
  align-items: center;
  border-radius: var(--radius-xl);
  display: grid;
  gap: var(--space-4);
  padding: var(--space-6);
}

.create-view__eyebrow {
  color: var(--primary);
  font-size: var(--text-xs);
  font-weight: var(--weight-black);
  letter-spacing: 0.04em;
  margin: 0 0 var(--space-1);
  text-transform: uppercase;
}

.create-view h1,
.create-view h2,
.create-view p {
  margin: 0;
}

.create-view h1 {
  font-size: var(--text-2xl);
  font-weight: var(--weight-black);
  line-height: 1.08;
}

.create-view__button {
  border: 0;
}

.create-view__drafts {
  display: grid;
  gap: var(--space-2);
}

.create-view__draft {
  border-radius: var(--radius-lg);
  padding: var(--space-4);
  align-items: center;
  display: flex;
  gap: var(--space-3);
  justify-content: space-between;
}

.create-view__draft p {
  color: var(--on-surface-muted);
  margin-top: var(--space-1);
}

.create-view__draft button {
  align-items: center;
  background: rgba(255, 180, 171, 0.1);
  border: 1px solid rgba(255, 180, 171, 0.2);
  border-radius: var(--radius-full);
  color: var(--error);
  cursor: pointer;
  display: inline-flex;
  flex: none;
  height: 40px;
  justify-content: center;
  width: 40px;
}

.create-view__draft button:disabled {
  cursor: default;
  opacity: 0.5;
}

.form-pop-enter-active,
.form-pop-leave-active {
  transition: opacity var(--duration-base) var(--ease-standard), transform var(--duration-base) var(--ease-standard);
}

.form-pop-enter-from,
.form-pop-leave-to {
  opacity: 0;
  transform: translateY(-12px);
}

@media (min-width: 720px) {
  .create-view__hero {
    grid-template-columns: 1fr auto;
  }
}
</style>
