# Frontend ↔ Backend Integration Map

Stack: Vue 3 PWA (`frontend/`, Vite dev on `127.0.0.1:5173`) + Laravel 11 API (`backend/`, PostgreSQL `tikvibe`, Sanctum tokens, queue=sync).

Environment notes:
- Port 8000 is occupied by an unrelated project (`lamsa-ecommer`) — this backend runs on **8001**; frontend points there via `frontend/.env.local`.
- ffmpeg/ffprobe are **not installed** and `QUEUE_CONNECTION=sync` (processing runs in-request). The metadata extractor binding auto-detects a missing ffprobe and falls back to a null extractor so uploads still complete (status `ready`, no thumbnail) instead of failing.

## Existing backend (reused as-is)

| Endpoint | Purpose | Frontend consumer |
| --- | --- | --- |
| `GET /api/videos` (cursor-paginated, cached first page) | Public feed (ready + public) | Home, Explore, Search (with `?search=`) |
| `GET /api/videos/{uuid}` | Video details + deduped view count | VideoDetails |
| `POST /api/videos` (auth, throttle) | Upload (multipart: video, title, description, visibility) | Create / UploadVideoForm |
| `DELETE /api/videos/{uuid}` (auth, owner) | Delete (soft) | Create "my uploads", Profile |

## Missing backend → added (following existing patterns)

| Endpoint | Purpose | Frontend consumer |
| --- | --- | --- |
| `POST /api/auth/register` | name/email/password+confirmation → `{token, user}` (201) | RegisterView |
| `POST /api/auth/login` | → `{token, user}`; 422 on bad credentials | LoginView |
| `GET /api/auth/me` (auth) | User + counts | store/auth hydrate, ProfileSummary |
| `POST /api/auth/logout` (auth) | Revoke token (204) | AppTopBar logout |
| `POST/DELETE /api/videos/{uuid}/likes` (auth) | Idempotent like toggle → `{likes_count, liked}` | VideoActionRail, VideoCard double-tap |
| `POST/DELETE /api/videos/{uuid}/saves` (auth) | Bookmark toggle → `{saved}` | VideoActionRail |
| `GET /api/videos/{uuid}/comments` | Cursor-paginated comments | CommentsSheet, VideoDetails |
| `POST /api/videos/{uuid}/comments` (auth) | Add comment (`body`, 422 validation) | CommentsSheet, VideoDetails |
| `DELETE /api/comments/{uuid}` (auth, owner) | Delete own comment | CommentsSheet, VideoDetails |
| `POST/DELETE /api/users/{id}/follows` (auth) | Follow toggle → `{followers_count, following}` | VideoActionRail follow badge |
| `GET /api/users/{id}/videos` | Public videos of a user (owner sees all statuses) | Profile |
| `GET /api/dashboard` (auth) | Stats: videos by status, views, likes, comments, followers | DashboardView |
| `GET /api/videos?search=term` | Search title/description (bypasses first-page cache) | SearchView, ExploreView |

Schema additions (new migrations, no changes to existing ones): `likes`, `comments` (uuid public key), `follows`, `saves` tables; `videos.likes_count`, `videos.comments_count`, `videos.tags` (json); `users.avatar_url`. Denormalized counters mirror the existing `views_count` pattern.

`VideoResource` gains: `tags`, `likes_count`, `comments_count`, `liked_by_me`, `saved_by_me`; `owner` gains `handle`, `avatar_url`, `is_followed_by_me`. `UserResource`: `id, name, handle, avatar_url, videos_count, followers_count, following_count, likes_received_count`.

Seeding: `DemoSeeder` — 6 creator users (password `password`), 8 videos backed by **real MP4 files** in `storage/app/public/videos/` (public sample clips), staggered `published_at`, tags, plus seeded likes/comments/follows. `php artisan storage:link` exposes them at `/storage/...`.

## Frontend changes

| Area | Change |
| --- | --- |
| `services/api.js` | 422 → reject with field `errors` (no toast); 401 logout; 403/404/409/500 + network → user-friendly toasts |
| `services/videos.js` (new) | feed(cursor, search), show, upload (FormData), delete, like/save toggles, comments CRUD; `mapVideo()` API→card adapter (compact count formatting) |
| `services/users.js` (new) | dashboard stats, user videos, follow toggles |
| `services/auth.js` | add `logoutRequest` |
| `store/auth.js` | logout calls API best-effort |
| `store/feed.js` | server-backed liked/saved/followed state with optimistic updates + rollback; comments fetched per video; keeps local `muted` + sheet state; guests → redirect to login |
| `HomeView` | API feed + cursor infinite scroll, loading/empty/error states |
| `VideoDetailsView` | fetch by uuid, 404 state, API comments + delete own |
| `ExploreView` / `SearchView` | real data; chips/search debounced via `?search=` |
| `ProfileView` / `ProfileSummary` | real user + counts + my videos grid, delete own video |
| `DashboardView` | real stat cards |
| `CreateView` / `UploadVideoForm` | real multipart upload (progress, 422 field errors, visibility `public/unlisted/private`), my-uploads list with status chips; localStorage drafts kept as-is |
| `VideoActionRail` / `CommentsSheet` | async store actions, in-flight disable, API comments |

Mock data removed: `services/feed.js` sample catalog deleted (categories list kept for chips). `store/feed.js` localStorage engagement replaced by API.
