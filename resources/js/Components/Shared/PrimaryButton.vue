<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { getSizeClasses } from "@/common-functions";

const props = defineProps({
    size: {
        type: String,
        default: "md",
    },
    type: {
        type: String,
        default: "button",
    },
    href: {
        type: String,
    },
});

const baseClasses =
    "rounded-md whitespace-nowrap bg-indigo-600 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600";

const sizeClasses = computed(() => {
    return getSizeClasses(props.size);
});
</script>

<template>
    <Link v-if="href" :href="href" :class="[sizeClasses, baseClasses]">
        <slot
    /></Link>
    <button v-else :class="[sizeClasses, baseClasses]">
        <slot />
    </button>
</template>
