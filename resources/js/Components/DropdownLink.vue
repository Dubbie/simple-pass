<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
});
</script>

<template>
    <Link
        v-if="href"
        :href="href"
        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
    <span
        v-else
        class="cursor-pointer block w-full px-4 py-2 text-left text-sm leading-5 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"
    >
        <slot />
    </span>
</template>
