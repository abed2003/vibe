# TikVibe Vue 3 PWA Phase Plan

## Project Structure

```text
frontend/
  public/
    pwa.svg
  src/
    assets/
      styles.css
    components/
      auth/
        AuthForm.vue
      common/
        AlertStack.vue
        BrandLogo.vue
        LoadingOverlay.vue
      feed/
        VideoActionRail.vue
        VideoCard.vue
      navigation/
        AppTopBar.vue
        BottomNav.vue
      profile/
        ProfileSummary.vue
      search/
        CategoryChips.vue
        SearchBar.vue
    layouts/
      AppLayout.vue
      AuthLayout.vue
    router/
      index.js
    services/
      api.js
      auth.js
      feed.js
    store/
      auth.js
      ui.js
    views/
      DashboardView.vue
      ExploreView.vue
      HomeView.vue
      LoginView.vue
      ProfileView.vue
      RegisterView.vue
      SearchView.vue
      SplashView.vue
      VideoDetailsView.vue
      WelcomeView.vue
    App.vue
    main.js
  index.html
  vite.config.js
```

## Raw To Vue Mapping

| Raw screen | Vue view | Reusable components extracted |
| --- | --- | --- |
| `splash_screen/code.html` | `SplashView.vue` | `BrandLogo.vue` |
| `welcome_screen/code.html` | `WelcomeView.vue` | `BrandLogo.vue`, shared buttons |
| `login/code.html` | `LoginView.vue` | `AuthLayout.vue`, `AuthForm.vue`, `BrandLogo.vue` |
| `register/code.html` | `RegisterView.vue` | `AuthLayout.vue`, `AuthForm.vue`, `BrandLogo.vue` |
| `home_feed/code.html` | `HomeView.vue` | `AppLayout.vue`, `AppTopBar.vue`, `BottomNav.vue`, `CategoryChips.vue`, `VideoCard.vue`, `VideoActionRail.vue` |
| `explore_page/code.html` | `ExploreView.vue` | `SearchBar.vue`, `CategoryChips.vue`, `VideoCard.vue` |
| `search_results/code.html` | `SearchView.vue` | `SearchBar.vue`, `VideoCard.vue` |
| `video_details/code.html` | `VideoDetailsView.vue` | `VideoCard.vue`, `VideoActionRail.vue`, comment/detail panel pattern |

## Conversion Steps

1. Normalize design tokens from `lumina/DESIGN.md` into `src/assets/styles.css`.
2. Replace repeated raw top bars and floating nav with `AppTopBar.vue` and `BottomNav.vue`.
3. Replace repeated auth form markup with a single Composition API `AuthForm.vue`.
4. Replace repeated video preview/action markup with `VideoCard.vue` and `VideoActionRail.vue`.
5. Move page-specific layout into views and keep data in services until backend endpoints are ready.
6. Keep route protection in `router/index.js` and session persistence in `store/auth.js`.

## Frontend Phase 1

- Vue 3 Composition API only.
- Vite app entry in `main.js`.
- Vue Router SPA routes:
  - `/` Home
  - `/login` Login
  - `/register` Register
  - `/dashboard` protected
  - `/profile` protected
  - `/explore`, `/search`, `/videos/:id`, `/splash`, `/welcome`
- Pinia stores:
  - `auth.js`: JWT token, user, localStorage persistence, login/register/logout.
  - `ui.js`: global loading and alert messages.
- API layer:
  - `services/api.js` creates the Axios instance.
  - request interceptor injects `Authorization: Bearer <token>`.
  - response interceptor handles loading, errors, and `401` logout.
- PWA:
  - `vite-plugin-pwa` configured in `vite.config.js`.
  - Manifest includes app name, SVG icon, theme colors, standalone display.
  - Workbox precaches core build assets and uses `NetworkFirst` for navigations.
  - Remote media uses `CacheFirst` with expiration.

## Backend Phase 2 Design Only

Preferred backend choices:

- Node.js: NestJS or Express with a modular service/repository structure.
- Laravel: API routes, Sanctum/JWT guard, policies for role checks.
- ASP.NET Core: controllers or minimal APIs, Identity/JWT bearer auth, authorization policies.

Suggested REST modules:

```text
backend/
  auth/
    POST /auth/register
    POST /auth/login
    GET  /auth/me
    POST /auth/logout
  users/
    GET    /users/:id
    PATCH  /users/:id
    GET    /users/:id/videos
  videos/
    GET    /videos
    POST   /videos
    GET    /videos/:id
    PATCH  /videos/:id
    DELETE /videos/:id
  interactions/
    POST   /videos/:id/likes
    DELETE /videos/:id/likes
    POST   /videos/:id/comments
    GET    /videos/:id/comments
  admin/
    GET    /admin/users
    PATCH  /admin/users/:id/role
```

Auth and security:

- JWT access token with refresh-token rotation.
- Roles: `admin`, `user`.
- Route middleware/policies for owner-only edits and admin-only management.
- Rate limit login, register, comments, and uploads.
- Validate payloads at the API boundary.
- Store password hashes only, never raw passwords.

Data entities:

- `User`: id, name, email, password_hash, role, avatar_url, created_at.
- `Video`: id, user_id, title, caption, media_url, cover_url, visibility, created_at.
- `Comment`: id, video_id, user_id, body, created_at.
- `Like`: id, video_id, user_id, created_at.
- `Follow`: follower_id, following_id, created_at.
