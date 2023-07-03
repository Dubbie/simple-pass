<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    size: {
        type: String,
        default: "md",
    },
    color: {
        type: String,
        default: "primary",
    },
    href: {
        type: String,
        required: false,
    },
});

const sizeClasses = computed(() => {
    return {
        sm: "py-1",
        md: "py-2",
        lg: "py-3",
        xl: "py-3",
        "2xl": "py-3",
    }[props.size];
});

const colorClasses = computed(() => {
    return {
        primary: "text-indigo-600 hover:text-indigo-400",
        danger: "text-red-600 hover:text-red-400",
        secondary: "text-gray-400 hover:text-gray-600",
    }[props.color];
});

const baseClasses =
    "inline-flex text-sm font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600";
</script>

<template>
    <Link
        v-if="href"
        :href="href"
        :class="[baseClasses, sizeClasses, colorClasses]"
    >
        <slot />
    </Link>

    <button v-else :class="[baseClasses, sizeClasses, colorClasses]">
        <slot />
    </button>
</template>
