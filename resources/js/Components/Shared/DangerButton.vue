<script setup>
import { getSizeClasses } from "@/common-functions";
import { computed } from "vue";

const props = defineProps({
    size: {
        type: String,
        default: "md",
    },
});

const sizeClasses = `${getSizeClasses(props.size)}`;
</script>

<template>
    <button
        class="rounded-md bg-red-600 font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        :class="sizeClasses"
    >
        <slot />
    </button>
</template>
