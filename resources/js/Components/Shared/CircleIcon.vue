<script setup>
import { computed } from "vue";

const props = defineProps({
    color: {
        type: String,
        default: "info",
    },
});

const colorClasses = computed(() => {
    return {
        info: "bg-blue-100 text-blue-600",
        danger: "bg-red-100 text-red-600",
        success: "bg-green-100 text-green-600",
        primary: "bg-indigo-100 text-indigo-600",
        warning: "bg-yellow-100 text-yellow-600",
    }[props.color];
});
</script>

<template>
    <div
        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
        :class="colorClasses"
    >
        <slot />
    </div>
</template>
