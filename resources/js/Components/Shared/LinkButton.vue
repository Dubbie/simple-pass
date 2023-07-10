<script setup>
import { getSizeClasses } from "@/common-functions";
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

const sizeClasses = `${getSizeClasses(props.size)}`;

const colorClasses = computed(() => {
    return {
        primary: "text-indigo-500 hover:text-indigo-300",
        danger: "text-red-600 hover:text-red-400",
        secondary: "text-white hover:text-gray-300",
    }[props.color];
});

const baseClasses =
    "inline-flex font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600";
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
