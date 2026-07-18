import api from './api';
import { mapVideo } from './videos';

/** User-scoped API calls: dashboard stats, per-user video lists, follows. */

export async function fetchDashboard() {
  const { data } = await api.get('/dashboard', { silent: true });
  return data;
}

export async function fetchUserVideos(userId, cursor = null) {
  const { data } = await api.get(`/users/${userId}/videos`, {
    params: cursor ? { cursor } : {},
    silent: true
  });

  return { videos: data.data.map(mapVideo), nextCursor: data.meta?.next_cursor || null };
}

export async function followUser(userId) {
  const { data } = await api.post(`/users/${userId}/follows`, {}, { silent: true });
  return data;
}

export async function unfollowUser(userId) {
  const { data } = await api.delete(`/users/${userId}/follows`, { silent: true });
  return data;
}
