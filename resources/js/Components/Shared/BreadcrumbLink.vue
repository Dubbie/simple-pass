<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
});

const classes = "text-gray-400 font-semibold leading-6";
const linkClasses = "hover:text-gray-600";
</script>

<template>
    <Link :href="href" v-if="href" :class="[classes, linkClasses]">
        <slot />
    </Link>

    <span v-else :class="classes">
        <slot />
    </span>
</template>
