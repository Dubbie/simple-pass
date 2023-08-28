<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: {
        type: File,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="block rounded-md border-0 py-1.5 bg-gray-800 text-white shadow-sm ring-1 ring-inset ring-gray-700 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 autofill:shadow-[inset_0_0_0px_1000px_rgb(21,31,45)]"
        type="file"
        @change="$emit('update:modelValue', $event.target.files)"
        ref="input"
    />
</template>
