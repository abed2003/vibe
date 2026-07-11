<template>
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="/" class="brand-gradient text-6xl font-extrabold tracking-normal">VIBE</a>
                <p class="mt-3 text-lg text-[#c6c4d8]">{{ isLogin ? 'Welcome back to the vibe.' : 'Create your identity.' }}</p>
            </div>
            <form class="glass space-y-5 rounded-3xl p-6" @submit.prevent="submit">
                <div v-if="!isLogin" class="flex justify-center">
                    <button type="button" class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-dashed border-white/20 bg-white/5 text-[#c6c4d8] hover:border-[#c0c1ff] hover:text-[#c0c1ff]">
                        <Icon name="add_a_photo" :size="34" />
                    </button>
                </div>
                <label v-if="!isLogin" class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#c6c4d8]">Username</span>
                    <input class="field" placeholder="@yourhandle">
                </label>
                <label v-if="!isLogin" class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#c6c4d8]">Full Name</span>
                    <input class="field" placeholder="Alex Rivers">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#c6c4d8]">Email Address</span>
                    <input class="field" type="email" placeholder="alex@vibe.app" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[#c6c4d8]">Password</span>
                    <input class="field" type="password" placeholder="Enter your password" required>
                </label>
                <div v-if="!isLogin" class="flex flex-wrap gap-2">
                    <button v-for="interest in interests" :key="interest" type="button" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-[#c6c4d8] hover:border-[#c0c1ff] hover:text-[#c0c1ff]">{{ interest }}</button>
                </div>
                <div v-if="isLogin" class="flex items-center justify-between text-sm font-semibold">
                    <label class="flex items-center gap-2 text-[#c6c4d8]"><input type="checkbox" class="rounded bg-white/10"> Remember me</label>
                    <a class="text-[#c0c1ff]" href="/contact">Need help?</a>
                </div>
                <button class="primary-button w-full rounded-full px-6 py-4 font-bold" type="submit">{{ isLogin ? 'Login to VIBE' : 'Create Account' }}</button>
            </form>
            <p class="mt-6 text-center text-[#c6c4d8]">
                {{ isLogin ? "Don't have an account?" : 'Already have an account?' }}
                <a class="font-bold text-[#c0c1ff]" :href="isLogin ? '/register' : '/login'">{{ isLogin ? 'Sign up' : 'Log in' }}</a>
            </p>
        </section>
    </main>
</template>

<script setup>
import { computed } from 'vue';
import Icon from '../components/Icon.vue';

const props = defineProps({
    mode: { type: String, default: 'login' },
});

const isLogin = computed(() => props.mode === 'login');
const interests = ['Music', 'Art', 'Gaming', 'Technology', 'Fashion', 'Sports', 'Travel'];

function submit() {
    window.location.href = '/feed';
}
</script>
