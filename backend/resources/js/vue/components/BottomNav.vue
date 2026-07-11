<template>
    <nav class="fixed inset-x-0 bottom-4 z-40 mx-auto flex h-16 max-w-[390px] items-center justify-around rounded-full border border-white/10 bg-[#0a0e14]/55 px-3 backdrop-blur-2xl">
        <a v-for="item in items" :key="item.href" :href="item.href" class="flex h-11 w-11 items-center justify-center rounded-full transition" :class="isActive(item) ? 'text-[#c0c1ff] bg-white/10' : 'text-[#c6c4d8]/65 hover:text-[#c0c1ff]'">
            <Icon :name="item.icon" :fill="isActive(item)" />
        </a>
    </nav>
</template>

<script setup>
import Icon from './Icon.vue';

const props = defineProps({
    path: { type: String, required: true },
});

const items = [
    { href: '/feed', icon: 'home' },
    { href: '/explore', icon: 'explore' },
    { href: '/videos/neon-flow', icon: 'add_circle' },
    { href: '/messages', icon: 'chat_bubble' },
    { href: '/contact', icon: 'contacts' },
];

function isActive(item) {
    return props.path === item.href || (item.href !== '/feed' && props.path.startsWith(item.href));
}
</script>
