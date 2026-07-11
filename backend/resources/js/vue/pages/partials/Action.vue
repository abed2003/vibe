<template>
    <button class="flex flex-col items-center gap-1">
        <span class="glass flex h-11 w-11 items-center justify-center rounded-full">
            <Icon :name="icon" :fill="fill" />
        </span>
        <span class="text-xs font-bold">{{ label }}</span>
    </button>
</template>

<script setup>
import Icon from '../../components/Icon.vue';

defineProps({
    icon: { type: String, required: true },
    label: { type: String, required: true },
    fill: { type: Boolean, default: false },
});
</script>
