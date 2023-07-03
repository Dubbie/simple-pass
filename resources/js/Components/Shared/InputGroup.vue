<script setup>
import { computed } from "vue";
import TextInput from "./TextInput.vue";

const props = defineProps({
    placeholder: {
        type: String,
    },
    suffix: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        required: true,
    },
});

const paddingClass = computed(() => {
    return "pr-10";
});
</script>

<template>
    <div class="relative">
        <TextInput
            type="text"
            class="w-full text-right"
            :class="paddingClass"
            :model-value="modelValue"
            :placeholder="placeholder"
            v-on:update:model-value="$emit('update:modelValue', $event)"
        />

        <span
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-500 pointer-events-none"
            >{{ suffix }}</span
        >
    </div>
</template>
