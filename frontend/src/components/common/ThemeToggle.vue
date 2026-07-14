<script setup>
import { computed } from 'vue';
import IconButton from './IconButton.vue';
import { useThemeStore } from '../../store/theme';

const themeStore = useThemeStore();

const isLight = computed(() => themeStore.theme === 'light');
const icon = computed(() => (isLight.value ? 'dark_mode' : 'light_mode'));
const label = computed(() => (isLight.value ? 'Switch to dark theme' : 'Switch to light theme'));
</script>

<template>
  <IconButton
    :icon="icon"
    :label="label"
    :aria-pressed="isLight"
    @click="themeStore.toggleTheme()"
  />
</template>
