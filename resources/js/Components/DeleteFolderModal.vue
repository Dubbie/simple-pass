<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import LinkButton from "@/Components/Shared/LinkButton.vue";
import DangerButton from "@/Components/Shared/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    folder: {
        type: Object,
    },
    show: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    moveFoldersOutside: false,
});

const emit = defineEmits(["close"]);

const handleSubmit = () => {
    form.delete(route("folders.destroy", props.folder), {
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};
</script>

<template>
    <Modal max-width="sm" :show="show" @close="$emit('close')">
        <form @submit.prevent="handleSubmit">
            <div class="p-4">
                <ModalTitle>Delete folder</ModalTitle>
                <div class="mt-4">
                    <label for="moveOutside" class="flex">
                        <input
                            id="moveOutside"
                            type="checkbox"
                            v-model="form.moveFoldersOutside"
                            class="mt-0.5 bg-gray-900 rounded"
                        />

                        <p class="text-white text-sm ml-2">
                            Would you like to move folders and entries inside
                            this folder to it's parent folder?
                        </p>
                    </label>
                </div>
                <div class="mt-4 flex items-center space-x-4">
                    <DangerButton type="submit" :disabled="form.processing"
                        >Delete folder</DangerButton
                    >
                    <LinkButton color="secondary" @click="$emit('close')"
                        >Cancel</LinkButton
                    >
                </div>
            </div>
        </form>
    </Modal>
</template>
