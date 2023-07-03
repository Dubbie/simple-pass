<script setup>
import { computed } from "vue";

const props = defineProps({
    size: {
        type: String,
        default: "sm",
    },
    color: {
        type: String,
        default: "success",
    },
});

const sizeClasses = computed(() => {
    return {
        sm: "px-2 py-1",
        md: "px-3 py-2",
        lg: "px-6 py-3",
        xl: "px-6 py-3",
        "2xl": "px-6 py-3",
    }[props.size];
});

const colorClasses = computed(() => {
    return {
        success: "text-emerald-600 bg-green-100 border-emerald-300",
        danger: "text-red-600 bg-red-50 border-red-300",
    }[props.color];
});
</script>

<template>
    <span
        class="rounded-md border text-sm leading-tight font-normal"
        :class="[sizeClasses, colorClasses]"
    >
        <slot />
    </span>
</template>
