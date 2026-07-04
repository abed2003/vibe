<script setup>
import { computed, onUnmounted, reactive, ref } from 'vue';

const emit = defineEmits(['cancel', 'submit']);

const fileInput = ref(null);
const previewUrl = ref('');
const form = reactive({
  title: '',
  caption: '',
  tags: '',
  visibility: 'public',
  file: null
});

const fileMeta = computed(() => {
  if (!form.file) return '';
  const mb = form.file.size / 1024 / 1024;
  return `${form.file.name} • ${mb.toFixed(1)} MB`;
});

function setPreview(file) {
  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value);
  }

  previewUrl.value = file ? URL.createObjectURL(file) : '';
}

function handleFileChange(event) {
  const [file] = event.target.files || [];
  form.file = file || null;
  setPreview(form.file);
}

function openFilePicker() {
  fileInput.value?.click();
}

function submit() {
  if (!form.file) return;

  emit('submit', {
    title: form.title.trim(),
    caption: form.caption.trim(),
    tags: form.tags
      .split(',')
      .map((tag) => tag.trim())
      .filter(Boolean),
    visibility: form.visibility,
    file: form.file
  });

  form.title = '';
  form.caption = '';
  form.tags = '';
  form.visibility = 'public';
  form.file = null;
  if (fileInput.value) fileInput.value.value = '';
  setPreview(null);
}

onUnmounted(() => {
  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value);
  }
});
</script>

<template>
  <form class="upload-form glass" @submit.prevent="submit">
    <div class="upload-form__header">
      <div>
        <h2>Upload video</h2>
        <p>Create a draft now. Backend publishing can connect to this form later.</p>
      </div>
      <button class="upload-form__close" type="button" aria-label="Close upload form" @click="$emit('cancel')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <button class="upload-form__dropzone" type="button" @click="openFilePicker">
      <input ref="fileInput" type="file" accept="video/*" hidden @change="handleFileChange" />
      <video v-if="previewUrl" :src="previewUrl" muted playsinline controls></video>
      <span v-else class="material-symbols-outlined">cloud_upload</span>
      <strong>{{ form.file ? fileMeta : 'Choose a video file' }}</strong>
      <small v-if="!form.file">MP4, MOV, or WebM</small>
    </button>

    <div class="upload-form__fields">
      <div class="field">
        <label for="video-title">Title</label>
        <div class="input-wrap">
          <span class="material-symbols-outlined">title</span>
          <input id="video-title" v-model.trim="form.title" required maxlength="80" placeholder="Neon city movement study" />
        </div>
      </div>

      <div class="field">
        <label for="video-caption">Caption</label>
        <textarea id="video-caption" v-model.trim="form.caption" maxlength="220" placeholder="Tell people what this video is about"></textarea>
      </div>

      <div class="field">
        <label for="video-tags">Tags</label>
        <div class="input-wrap">
          <span class="material-symbols-outlined">tag</span>
          <input id="video-tags" v-model="form.tags" placeholder="dance, night, cinematic" />
        </div>
      </div>

      <div class="field">
        <label for="video-visibility">Visibility</label>
        <select id="video-visibility" v-model="form.visibility">
          <option value="public">Public</option>
          <option value="followers">Followers only</option>
          <option value="private">Private draft</option>
        </select>
      </div>
    </div>

    <div class="upload-form__actions">
      <button class="app-button ghost" type="button" @click="$emit('cancel')">Cancel</button>
      <button class="app-button primary" type="submit" :disabled="!form.file">Create draft</button>
    </div>
  </form>
</template>

<style scoped>
.upload-form {
  animation: slideDown 220ms ease both;
  border-radius: var(--radius-xl);
  display: grid;
  gap: 18px;
  padding: 18px;
}

.upload-form__header {
  align-items: start;
  display: flex;
  gap: 14px;
  justify-content: space-between;
}

.upload-form__header h2,
.upload-form__header p {
  margin: 0;
}

.upload-form__header p {
  color: var(--on-surface-muted);
  margin-top: 6px;
}

.upload-form__close {
  align-items: center;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 999px;
  color: var(--on-surface);
  cursor: pointer;
  display: inline-flex;
  height: 40px;
  justify-content: center;
  width: 40px;
}

.upload-form__dropzone {
  align-items: center;
  background: rgba(10, 14, 20, 0.54);
  border: 1px dashed rgba(192, 193, 255, 0.52);
  border-radius: var(--radius-lg);
  color: var(--on-surface);
  cursor: pointer;
  display: grid;
  gap: 8px;
  justify-items: center;
  min-height: 220px;
  overflow: hidden;
  padding: 18px;
  text-align: center;
}

.upload-form__dropzone .material-symbols-outlined {
  color: var(--primary);
  font-size: 44px;
}

.upload-form__dropzone video {
  aspect-ratio: 9 / 16;
  border-radius: var(--radius-md);
  max-height: 280px;
  max-width: 100%;
  object-fit: cover;
}

.upload-form__dropzone small {
  color: var(--on-surface-muted);
}

.upload-form__fields {
  display: grid;
  gap: 14px;
}

.upload-form textarea,
.upload-form select {
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid transparent;
  border-radius: 14px;
  color: var(--on-surface);
  min-height: 48px;
  outline: 0;
  padding: 13px 14px;
  width: 100%;
}

.upload-form textarea {
  min-height: 104px;
  resize: vertical;
}

.upload-form select option {
  background: var(--surface);
}

.upload-form__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  justify-content: flex-end;
}

.upload-form__actions .app-button:disabled {
  cursor: not-allowed;
  opacity: 0.55;
  transform: none;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-16px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
