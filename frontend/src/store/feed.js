import { defineStore } from 'pinia';
import * as videosApi from '../services/videos';
import * as usersApi from '../services/users';

const STORAGE_KEY = 'tikvibe.feed';

function readStored() {
  try {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
  } catch {
    return {};
  }
}

function blankComments() {
  return { list: [], nextCursor: null, loaded: false, loading: false };
}

/**
 * Server-backed engagement state. The API is the source of truth for likes,
 * saves, follows and comments; this store keeps a per-video view of that
 * state (hydrated from API payloads) consistent across views, applies
 * optimistic updates with rollback, and drives the comments bottom sheet.
 * Only the sound preference is persisted locally.
 */
export const useFeedStore = defineStore('feed', {
  state: () => ({
    muted: readStored().muted !== false,
    activeCommentsVideoId: null,
    engagement: {},
    commentsByVideo: {},
    pending: {}
  }),
  getters: {
    stateFor: (state) => (video) =>
      state.engagement[video.id] || {
        liked: Boolean(video.liked),
        saved: Boolean(video.saved),
        following: Boolean(video.followingCreator),
        likesCount: video.likes ?? 0,
        commentsCount: video.comments ?? 0
      },
    commentsFor: (state) => (video) => state.commentsByVideo[video.id] || blankComments()
  },
  actions: {
    persist() {
      localStorage.setItem(STORAGE_KEY, JSON.stringify({ muted: this.muted }));
    },
    setMuted(value) {
      this.muted = Boolean(value);
      this.persist();
    },
    /** Refresh the store's view of a video from a fresh API payload. */
    hydrate(video) {
      this.engagement[video.id] = {
        liked: Boolean(video.liked),
        saved: Boolean(video.saved),
        following: Boolean(video.followingCreator),
        likesCount: video.likes ?? 0,
        commentsCount: video.comments ?? 0
      };
    },
    hydrateAll(videos) {
      videos.forEach((video) => this.hydrate(video));
    },
    async toggleLike(video) {
      const key = `like:${video.id}`;
      if (this.pending[key]) return;

      const previous = { ...this.stateFor(video) };
      this.engagement[video.id] = {
        ...previous,
        liked: !previous.liked,
        likesCount: Math.max(0, previous.likesCount + (previous.liked ? -1 : 1))
      };
      this.pending[key] = true;

      try {
        const result = previous.liked
          ? await videosApi.unlikeVideo(video.id)
          : await videosApi.likeVideo(video.id);

        this.engagement[video.id] = {
          ...this.engagement[video.id],
          liked: result.liked,
          likesCount: result.likes_count
        };
      } catch {
        this.engagement[video.id] = previous;
      } finally {
        this.pending[key] = false;
      }
    },
    /** Double-tap: only ever likes, never unlikes. */
    async like(video) {
      if (!this.stateFor(video).liked) {
        await this.toggleLike(video);
      }
    },
    async toggleSave(video) {
      const key = `save:${video.id}`;
      if (this.pending[key]) return;

      const previous = { ...this.stateFor(video) };
      this.engagement[video.id] = { ...previous, saved: !previous.saved };
      this.pending[key] = true;

      try {
        const result = previous.saved
          ? await videosApi.unsaveVideo(video.id)
          : await videosApi.saveVideo(video.id);

        this.engagement[video.id] = { ...this.engagement[video.id], saved: result.saved };
        return result.saved;
      } catch {
        this.engagement[video.id] = previous;
        return previous.saved;
      } finally {
        this.pending[key] = false;
      }
    },
    async toggleFollow(video) {
      if (!video.creatorId) return video.followingCreator;

      const key = `follow:${video.creatorId}`;
      if (this.pending[key]) return this.stateFor(video).following;

      const previous = { ...this.stateFor(video) };
      this.engagement[video.id] = { ...previous, following: !previous.following };
      this.pending[key] = true;

      try {
        const result = previous.following
          ? await usersApi.unfollowUser(video.creatorId)
          : await usersApi.followUser(video.creatorId);

        this.engagement[video.id] = { ...this.engagement[video.id], following: result.following };
        return result.following;
      } catch {
        this.engagement[video.id] = previous;
        return previous.following;
      } finally {
        this.pending[key] = false;
      }
    },
    async loadComments(video, { reset = false } = {}) {
      const entry = this.commentsByVideo[video.id] || blankComments();
      this.commentsByVideo[video.id] = entry;

      if (entry.loading) return;
      if (entry.loaded && !reset && !entry.nextCursor) return;

      entry.loading = true;

      try {
        const { comments, nextCursor } = await videosApi.fetchComments(
          video.id,
          reset ? null : entry.nextCursor
        );

        entry.list = reset ? comments : [...entry.list, ...comments];
        entry.nextCursor = nextCursor;
        entry.loaded = true;
      } finally {
        entry.loading = false;
      }
    },
    async addComment(video, text) {
      const comment = await videosApi.addComment(video.id, text);

      const entry = this.commentsByVideo[video.id] || blankComments();
      this.commentsByVideo[video.id] = entry;
      entry.list.unshift(comment);
      entry.loaded = true;

      const state = this.stateFor(video);
      this.engagement[video.id] = { ...state, commentsCount: state.commentsCount + 1 };
    },
    async removeComment(video, comment) {
      await videosApi.deleteComment(comment.id);

      const entry = this.commentsByVideo[video.id];
      if (entry) {
        entry.list = entry.list.filter((item) => item.id !== comment.id);
      }

      const state = this.stateFor(video);
      this.engagement[video.id] = { ...state, commentsCount: Math.max(0, state.commentsCount - 1) };
    },
    openComments(videoId) {
      this.activeCommentsVideoId = videoId;
    },
    closeComments() {
      this.activeCommentsVideoId = null;
    }
  }
});
