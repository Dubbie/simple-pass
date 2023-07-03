<script setup>
import getSizeClasses from "@/common-functions";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    size: {
        type: String,
        default: "md",
    },
    href: String,
    type: {
        type: String,
        default: "button",
    },
});

const sizeClasses = computed(() => {
    return getSizeClasses(props.size);
});

const baseClasses =
    "inline-flex justify-center rounded-md bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50";
</script>

<template>
    <Link v-if="href" :href="href" :class="[baseClasses, sizeClasses]">
        <slot />
    </Link>

    <button v-else :type="type" :class="[baseClasses, sizeClasses]">
        <slot />
    </button>
</template>
