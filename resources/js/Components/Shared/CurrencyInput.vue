<script setup>
import { computed } from "vue";
import TextInput from "./TextInput.vue";
import { watch } from "vue";
import { vMaska } from "maska";

const props = defineProps({
    currency: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        required: true,
    },
});

const currencyLabel = computed(() => {
    switch (props.currency) {
        case "HUF":
            return "Ft";
        default:
            return props.currency;
    }
});

const paddingClass = computed(() => {
    switch (props.currency) {
        case "HUF":
            return "pr-8";
        default:
            return "pr-12";
    }
});

watch(props, (newValue) => {
    console.log(newValue.modelValue);
});
</script>

<template>
    <div class="relative">
        <TextInput
            type="text"
            class="w-full text-right"
            :class="paddingClass"
            :model-value="modelValue"
            placeholder="0"
            v-maska
            data-maska="9 99"
            data-maska-tokens="9:[0-9]:repeated"
            v-on:update:model-value="$emit('update:modelValue', $event)"
        />

        <span
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-500 pointer-events-none"
            >{{ currencyLabel }}</span
        >
    </div>
</template>
