<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: {
        type: Boolean,
        default: false,
    },
});

const activeClasses = props.active
    ? "text-white bg-gray-800"
    : "text-gray-400 hover:text-white hover:bg-gray-800";
const iconClass = props.active
    ? "text-white"
    : "text-gray-400 group-hover:text-white";
</script>

<template>
    <Link
        :href="href"
        class="leading-6 text-sm font-semibold gap-x-3 flex p-2 rounded-md group"
        :class="activeClasses"
    >
        <div v-if="$slots.icon" :class="iconClass">
            <slot name="icon" v-if="$slots.icon" />
        </div>

        <slot />
    </Link>
</template>
