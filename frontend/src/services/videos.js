import api from './api';

/**
 * Video API service: every function maps 1:1 to a backend endpoint and
 * returns view-model-shaped data (see mapVideo/mapComment). No view talks to
 * axios directly.
 */

const apiOrigin = (import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api').replace(/\/api\/?$/, '');

/**
 * Backend storage URLs carry the backend's configured APP_URL origin, which
 * in local dev rarely matches where the file server actually listens. Rewrite
 * same-origin storage paths to the API origin; external (CDN/S3) URLs pass
 * through untouched.
 */
function absoluteUrl(url) {
  if (!url) return null;
  if (url.startsWith('/')) return `${apiOrigin}${url}`;

  try {
    const parsed = new URL(url);
    if (parsed.pathname.startsWith('/storage/')) {
      return `${apiOrigin}${parsed.pathname}${parsed.search}`;
    }
  } catch {
    /* not a parseable URL — return as-is */
  }

  return url;
}

/** 1234 -> '1.2K', 2500000 -> '2.5M' (TikTok-style compact counts). */
export function formatCount(value) {
  const num = Number(value) || 0;

  if (num >= 1_000_000) return `${(num / 1_000_000).toFixed(1).replace(/\.0$/, '')}M`;
  if (num >= 1_000) return `${(num / 1_000).toFixed(1).replace(/\.0$/, '')}K`;

  return `${num}`;
}

/** ISO timestamp -> TikTok-style relative label ('3h', '2d', ...). */
export function timeAgo(iso) {
  if (!iso) return '';
  const seconds = Math.max(1, Math.floor((Date.now() - new Date(iso).getTime()) / 1000));

  if (seconds < 60) return `${seconds}s`;
  const minutes = Math.floor(seconds / 60);
  if (minutes < 60) return `${minutes}m`;
  const hours = Math.floor(minutes / 60);
  if (hours < 24) return `${hours}h`;
  const days = Math.floor(hours / 24);
  if (days < 7) return `${days}d`;
  const weeks = Math.floor(days / 7);
  if (weeks < 5) return `${weeks}w`;

  return new Date(iso).toLocaleDateString();
}

/** API video payload -> view model consumed by VideoCard and friends. */
export function mapVideo(video) {
  return {
    id: video.uuid,
    title: video.title || 'Untitled video',
    creator: video.owner?.name || 'Unknown creator',
    creatorId: video.owner?.id ?? null,
    handle: video.owner?.handle || '',
    avatar: video.owner?.avatar_url || null,
    cover: absoluteUrl(video.thumbnail_url),
    video: absoluteUrl(video.url),
    caption: video.description || '',
    tags: video.tags || [],
    likes: video.likes_count ?? 0,
    comments: video.comments_count ?? 0,
    views: video.views_count ?? 0,
    status: video.status,
    visibility: video.visibility,
    liked: Boolean(video.liked_by_me),
    saved: Boolean(video.saved_by_me),
    followingCreator: Boolean(video.owner?.is_followed_by_me),
    publishedAt: video.published_at
  };
}

/** API comment payload -> view model for CommentsSheet / VideoDetailsView. */
export function mapComment(comment) {
  return {
    id: comment.uuid,
    author: comment.author?.name || 'Unknown',
    handle: comment.author?.handle || '',
    avatar: comment.author?.avatar_url || null,
    text: comment.body,
    timeAgo: timeAgo(comment.created_at),
    mine: Boolean(comment.mine)
  };
}

export async function fetchFeed({ cursor = null, search = '' } = {}) {
  const { data } = await api.get('/videos', {
    params: {
      ...(cursor ? { cursor } : {}),
      ...(search ? { search } : {})
    },
    silent: true
  });

  return { videos: data.data.map(mapVideo), nextCursor: data.meta?.next_cursor || null };
}

export async function fetchVideo(uuid) {
  const { data } = await api.get(`/videos/${uuid}`, { silent: true });
  return mapVideo(data.data);
}

export async function uploadVideo({ file, title, description, tags, visibility, onProgress }) {
  const formData = new FormData();
  formData.append('video', file);
  if (title) formData.append('title', title);
  if (description) formData.append('description', description);
  if (visibility) formData.append('visibility', visibility);
  (tags || []).forEach((tag) => formData.append('tags[]', tag));

  const { data } = await api.post('/videos', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
    timeout: 120000,
    onUploadProgress: (event) => {
      if (onProgress && event.total) {
        onProgress(Math.round((event.loaded / event.total) * 100));
      }
    }
  });

  return mapVideo(data.data);
}

export async function deleteVideo(uuid) {
  await api.delete(`/videos/${uuid}`);
}

export async function likeVideo(uuid) {
  const { data } = await api.post(`/videos/${uuid}/likes`, {}, { silent: true });
  return data;
}

export async function unlikeVideo(uuid) {
  const { data } = await api.delete(`/videos/${uuid}/likes`, { silent: true });
  return data;
}

export async function saveVideo(uuid) {
  const { data } = await api.post(`/videos/${uuid}/saves`, {}, { silent: true });
  return data;
}

export async function unsaveVideo(uuid) {
  const { data } = await api.delete(`/videos/${uuid}/saves`, { silent: true });
  return data;
}

export async function fetchComments(uuid, cursor = null) {
  const { data } = await api.get(`/videos/${uuid}/comments`, {
    params: cursor ? { cursor } : {},
    silent: true
  });

  return { comments: data.data.map(mapComment), nextCursor: data.meta?.next_cursor || null };
}

export async function addComment(uuid, body) {
  const { data } = await api.post(`/videos/${uuid}/comments`, { body }, { silent: true });
  return mapComment(data.data);
}

export async function deleteComment(uuid) {
  await api.delete(`/comments/${uuid}`, { silent: true });
}
