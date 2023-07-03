<script setup>
import AppTooltip from "./AppTooltip.vue";

defineProps({
    value: {
        type: String,
    },
    tooltip: {
        type: String,
    },
});
</script>

<template>
    <label
        class="flex text-sm font-medium leading-6 text-gray-900 items-center justify-between sm:justify-start"
    >
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>

        <AppTooltip v-if="tooltip" :message="tooltip" class="ml-1" />
    </label>
</template>
