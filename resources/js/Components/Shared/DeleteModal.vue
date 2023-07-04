<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import LinkButton from "@/Components/Shared/LinkButton.vue";
import DangerButton from "@/Components/Shared/DangerButton.vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    callback: {
        type: Function,
        required: true,
    },
});

defineEmits(["close"]);
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-4">
            <ModalTitle><slot name="title" /></ModalTitle>
            <p class="text-sm text-gray-400">
                <slot name="body" />
            </p>
            <div class="mt-4 flex items-center space-x-4">
                <DangerButton @click="callback">Yes, delete</DangerButton>
                <LinkButton color="secondary" @click="$emit('close')"
                    >Cancel</LinkButton
                >
            </div>
        </div>
    </Modal>
</template>
