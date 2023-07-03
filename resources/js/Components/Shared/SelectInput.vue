<script setup>
defineProps({
    modelValue: {
        type: String,
    },
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        class="block text-sm leading-6 rounded-md border-0 py-1.5 bg-gray-800 text-white shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-indigo-500"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <slot />
    </select>
</template>
