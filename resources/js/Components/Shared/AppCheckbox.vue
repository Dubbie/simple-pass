<script setup>
import { ref } from "vue";
import AppTooltip from "./AppTooltip.vue";

defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: false,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);
</script>

<template>
    <div class="relative flex gap-x-3">
        <div class="flex h-6 items-center">
            <input
                type="checkbox"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.checked)"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                ref="input"
            />
        </div>
        <div class="text-sm leading-6">
            <label class="font-medium text-gray-900" @click="input.click()">{{
                label
            }}</label>
            <p class="text-gray-500 text-xs" v-if="description">
                {{ description }}
            </p>
        </div>
    </div>
</template>
