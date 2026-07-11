<template>
    <component :is="currentPage" :path="path" :mode="authMode" />
</template>

<script setup>
import { computed, ref } from 'vue';
import WelcomePage from './pages/WelcomePage.vue';
import SplashPage from './pages/SplashPage.vue';
import AuthPage from './pages/AuthPage.vue';
import FeedPage from './pages/FeedPage.vue';
import ExplorePage from './pages/ExplorePage.vue';
import SearchPage from './pages/SearchPage.vue';
import VideoPage from './pages/VideoPage.vue';
import MessagesPage from './pages/MessagesPage.vue';
import ContactPage from './pages/ContactPage.vue';

const path = ref(window.location.pathname);

window.addEventListener('popstate', () => {
    path.value = window.location.pathname;
});

const currentPage = computed(() => {
    if (path.value === '/splash') return SplashPage;
    if (path.value === '/login') return AuthPage;
    if (path.value === '/register') return AuthPage;
    if (path.value === '/feed') return FeedPage;
    if (path.value === '/explore') return ExplorePage;
    if (path.value === '/search') return SearchPage;
    if (path.value === '/messages') return MessagesPage;
    if (path.value === '/contact') return ContactPage;
    if (path.value.startsWith('/videos')) return VideoPage;
    return WelcomePage;
});

const authMode = computed(() => (path.value === '/register' ? 'register' : 'login'));
</script>
