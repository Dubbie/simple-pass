<script setup>
defineProps({
    code: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <p class="flex space-x-4 mt-4">
        <span
            v-for="character in code"
            class="text-5xl font-semibold rounded-xl px-3"
            >{{ character }}</span
        >
    </p>
</template>
