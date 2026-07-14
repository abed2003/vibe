<script setup>
import { ref } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import UploadVideoForm from '../components/video/UploadVideoForm.vue';
import { useUiStore } from '../store/ui';
import { useVideosStore } from '../store/videos';

const isFormOpen = ref(false);
const uiStore = useUiStore();
const videosStore = useVideosStore();

function createDraft(payload) {
  const draft = videosStore.createDraft(payload);
  isFormOpen.value = false;
  uiStore.notify({
    type: 'success',
    message: `${draft.title} was created as a video draft.`
  });
}
</script>

<template>
  <AppLayout>
    <section class="create-view">
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
        <UploadVideoForm v-if="isFormOpen" @cancel="isFormOpen = false" @submit="createDraft" />
      </Transition>

      <section class="create-view__drafts">
        <div class="create-view__section-title">
          <h2>Drafts</h2>
          <span>{{ videosStore.drafts.length }}</span>
        </div>
        <article v-if="!videosStore.drafts.length" class="create-view__empty glass">
          <span class="material-symbols-outlined">video_library</span>
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

.create-view__section-title {
  align-items: center;
  display: flex;
  justify-content: space-between;
}

.create-view__section-title span {
  background: rgba(255, 255, 255, 0.1);
  border-radius: var(--radius-full);
  font-weight: var(--weight-black);
  min-width: 32px;
  padding: 6px var(--space-2);
  text-align: center;
}

html.light .create-view__section-title span {
  background: rgba(20, 20, 30, 0.06);
}

.create-view__empty,
.create-view__draft {
  border-radius: var(--radius-lg);
  padding: var(--space-4);
}

.create-view__empty {
  align-items: center;
  color: var(--on-surface-muted);
  display: flex;
  gap: var(--space-2);
}

.create-view__draft {
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
  height: 40px;
  justify-content: center;
  width: 40px;
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
