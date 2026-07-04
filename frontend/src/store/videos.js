import { defineStore } from 'pinia';

const STORAGE_KEY = 'tikvibe.videoDrafts';

function readDrafts() {
  try {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  } catch {
    return [];
  }
}

export const useVideosStore = defineStore('videos', {
  state: () => ({
    drafts: readDrafts()
  }),
  actions: {
    persist() {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(this.drafts));
    },
    createDraft(payload) {
      const draft = {
        id: crypto.randomUUID(),
        title: payload.title,
        caption: payload.caption,
        tags: payload.tags,
        visibility: payload.visibility,
        fileName: payload.file?.name || null,
        fileSize: payload.file?.size || 0,
        status: 'draft',
        createdAt: new Date().toISOString()
      };

      this.drafts.unshift(draft);
      this.persist();
      return draft;
    },
    removeDraft(id) {
      this.drafts = this.drafts.filter((draft) => draft.id !== id);
      this.persist();
    }
  }
});
