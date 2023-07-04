<script setup>
import { getSizeClasses } from "@/common-functions";
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

const sizeClasses = `${getSizeClasses(props.size)}`;

const baseClasses =
    "inline-flex justify-center rounded-md bg-gray-800 font-semibold text-white shadow-sm hover:bg-gray-700 group-hover:bg-gray-700";
</script>

<template>
    <Link v-if="href" :href="href" :class="[baseClasses, sizeClasses]">
        <slot />
    </Link>

    <button v-else :type="type" :class="[baseClasses, sizeClasses]">
        <slot />
    </button>
</template>
