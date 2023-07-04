<script setup>
import TextInput from "@/Components/Shared/TextInput.vue";
import { computed } from "vue";
import { ref } from "vue";

const props = defineProps({
    inputProps: {
        type: Object,
    },
    modelValue: {
        type: String,
    },
});

const showPassword = ref(false);

const inputProps = computed(() => {
    return {
        ...props.inputProps,
        autocomplete: "new-password",
    };
});

const passwordInputType = computed(() => {
    return showPassword.value ? "text" : "password";
});

const toggleShowPassword = () => {
    showPassword.value = !showPassword.value;
};

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="relative">
        <TextInput
            :type="passwordInputType"
            v-bind="{ ...inputProps }"
            v-bind:model-value="modelValue"
            @update:model-value="$emit('update:modelValue', $event)"
        />

        <span
            class="cursor-pointer absolute top-0 py-2.5 pr-3 right-0 text-gray-400 text-xs font-bold hover:text-white"
            @click="toggleShowPassword"
            >{{ showPassword ? "Hide" : "Show" }}</span
        >
    </div>
</template>
