<script setup>
import TextInput from "@/Components/Base/TextInput.vue";
import { ref } from "vue";
import InputError from "../InputError.vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    inputProps: {
        type: Object,
    },
    showComboboxResults: {
        type: Boolean,
        required: true,
    },
    errorMessage: {
        type: String,
        required: false,
    },
});

defineEmits([
    "update:modelValue",
    "hideComboboxResults",
    "showComboboxResults",
]);

const open = ref(false);
</script>

<template>
    <div class="relative">
        <TextInput
            v-bind="{ ...inputProps }"
            :model-value="modelValue"
            @update:model-value="
                (data) => {
                    const newData = data === '' ? '' : data;
                    $emit('update:modelValue', newData);
                }
            "
        />
        <InputError class="mt-1" v-if="errorMessage" :message="errorMessage" />

        <!-- Background to hide combobox results -->
        <div
            v-show="open"
            class="fixed inset-0 z-0"
            @click="open = false"
        ></div>

        <div
            v-if="showComboboxResults"
            class="bg-white absolute border shadow-lg py-1 rounded-md overflow-auto max-h-60 w-full mt-1 sm:text-sm"
        >
            <slot name="content" />
        </div>
    </div>
</template>
