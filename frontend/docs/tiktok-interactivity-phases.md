# TikTok-Style Interactivity — Phase Plan

Roadmap for making the TikVibe frontend behave like the real TikTok app.
Phases 1–3 are **done** (see `git log` / this branch). Phases 4–6 are pending.

## Phase 1 — Immersive Feed Shell ✅ Done

Goal: the Home page becomes a full-screen vertical video feed, not a scrolling list.

- `src/views/HomeView.vue`
  - Feed container: `height: 100dvh`, `scroll-snap-type: y mandatory`, hidden scrollbar.
  - Each item: `100dvh`, `scroll-snap-align: start`, `scroll-snap-stop: always`, centered 9:16 column (`width: min(100%, calc(100dvh * 9 / 16))`).
  - Floating "Following | For You" tab bar over the video (fixed, top-center).
  - Keyboard (↑/↓, PageUp/PageDown) and debounced wheel navigation — one video per gesture.
- `src/layouts/AppLayout.vue` — new `immersive` prop: skips `AppTopBar`, removes page padding.
- `src/assets/styles.css` — `.page-shell--immersive` (edge-to-edge, `overflow: hidden`).
- `src/components/navigation/BottomNav.vue` — transparent overlay variant on the home route (white icons, no glass pill).
- `src/components/feed/VideoCard.vue` — new `full` prop: card fills its snap item, no rounded corners/shadow.

Acceptance: Home snaps exactly one video per scroll/wheel/arrow gesture; no page chrome except bottom nav; desktop shows a centered phone-width column.

## Phase 2 — Core Touch Interactions ✅ Done

Goal: the video surface responds like TikTok.

- `src/components/feed/VideoCard.vue`
  - Single tap → play/pause with animated center play icon (280 ms tap/double-tap disambiguation).
  - Double tap → like + heart-burst animation at tap coordinates (`heart-burst` keyframes, random rotation, `navigator.vibrate(15)`); never toggles play.
  - Bottom progress bar driven by `timeupdate` (`currentTime / duration`).
  - Mute toggle button (top-right) bound to a global sound preference; autoplay falls back to muted when the browser blocks sound.
  - Expandable caption (1-line clamp + "more"), hashtag chips, scrolling music ticker (`music-ticker` marquee).
  - IntersectionObserver: plays at >60% visibility, pauses and resets to 0 when scrolled away; `loop`, `playsinline`, `preload="metadata"`.

Acceptance: tap/double-tap never conflict; hearts spawn where tapped; progress tracks playback; sound survives across videos.

## Phase 3 — Social Layer ✅ Done

Goal: likes, saves, follows, and comments are real and persistent (frontend-only; backend has no interaction endpoints yet).

- `src/store/feed.js` (new Pinia store)
  - State: `likedIds`, `savedIds`, `followedHandles`, `commentsByVideo`, `muted` — persisted to `localStorage` key `tikvibe.feed`.
  - Actions: `toggleLike`, `like` (double-tap, never unlikes), `toggleSave`, `toggleFollow`, `setMuted`, `ensureComments`, `addComment`, `toggleCommentLike`, `openComments`/`closeComments` (sheet driver).
  - Exported `bumpCount(value, delta)` helper for formatted counts (`248K` → `248.1K`).
- `src/components/feed/VideoActionRail.vue`
  - Creator avatar with follow +/✓ badge; like pop animation; counts react to the store; comment button opens the sheet instead of routing; share keeps `navigator.share`/clipboard fallback.
- `src/components/feed/CommentsSheet.vue` (new)
  - Teleported slide-up bottom sheet (≤72dvh), backdrop/Esc close, focus-on-open composer, per-comment likes, "you" marker on own comments.
- `src/views/VideoDetailsView.vue` — interactive `VideoCard` (`auto-observe=false`) + store-backed comment list with composer.
- `src/services/feed.js` — catalog expanded 3 → 10 videos; per-video `music` and `seedComments`.

Acceptance: engagement survives reload; comments added in the sheet also appear on the details page (same store).

## Phase 4 — Secondary Pages Polish ⬜ Pending

Goal: bring the rest of the app up to the same standard.

- `ExploreView.vue`: masonry-style mixed-size grid, trending-hashtag header rows, hover-to-preview on desktop.
- `SearchView.vue`: recent searches (localStorage), suggestion dropdown (creators + tags), keyboard navigation of results.
- `ProfileView.vue`: tabs (Videos / Liked / Saved — the store already has the data), stats row (following/followers/likes), grid items with like-count overlay.
- `CreateView.vue`: real client-side video preview + thumbnail capture, caption character counter, post → inserts into the local feed.

Acceptance: Liked/Saved tabs reflect `store/feed.js`; search suggestions filter as you type; created video appears on Home.

## Phase 5 — Backend Integration ⬜ Pending

Goal: replace mock data with the Laravel API (per `phase-plan.md` Phase 2).

- Wire `GET /api/videos` (exists) into `services/feed.js` with mock fallback; map API fields (`media_url`, `cover_url`) to the card model.
- Add missing endpoints: `POST/DELETE /videos/:id/likes`, `GET/POST /videos/:id/comments`, `POST/DELETE /users/:handle/follows`.
- Replace `localStorage` engagement with API calls + optimistic updates (keep local state as cache).
- Cursor-based pagination/infinite scroll for the feed; upload pipeline for `CreateView`.

Acceptance: feed loads from the API; likes/comments persist server-side per user; feed pages fetch incrementally.

## Phase 6 — Performance, PWA & QA ⬜ Pending

- Feed virtualization (render only active ±1 video); adaptive `preload` (current = auto, neighbors = metadata, rest = none).
- Workbox runtime caching tuned for video range requests; offline fallback page.
- Reduced-motion support (disable burst/ticker animations), aria-live for toasts, focus trap in the comments sheet.
- Component tests (tap/double-tap disambiguation, store persistence) + a Playwright e2e pass over the feed.
- Lighthouse audit: ≥90 performance on the feed route.

Acceptance: no layout shift while scrolling the feed; tests green; PWA installable with working offline shell.
