<template>
    <span class="material-symbols-outlined" :style="iconStyle">{{ name }}</span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: { type: String, required: true },
    fill: { type: Boolean, default: false },
    size: { type: [Number, String], default: 24 },
});

const iconStyle = computed(() => ({
    fontVariationSettings: `'FILL' ${props.fill ? 1 : 0}`,
    fontSize: typeof props.size === 'number' ? `${props.size}px` : props.size,
}));
</script>
