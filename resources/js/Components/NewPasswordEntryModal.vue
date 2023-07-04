<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import TextInput from "@/Components/Shared/TextInput.vue";
import TextareaInput from "@/Components/Shared/TextareaInput.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    folderId: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    title: "",
    folder_id: props.folderId,
    username: "",
    password: "",
    url: "",
    notes: "",
});

const emit = defineEmits(["close"]);

const handleSubmission = () => {
    form.post(route("password-entries.store"), {
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <form @submit.prevent="handleSubmission" class="p-4" autocomplete="off">
            <ModalTitle>New entry</ModalTitle>

            <div class="mt-2">
                <InputLabel for="title" value="Title" />
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="new-username" value="Username" />
                <TextInput
                    id="new-username"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="off"
                    v-model="form.username"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="new-password" value="Password" />
                <TextInput
                    id="new-password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    v-model="form.password"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="url" value="Url" />
                <TextInput
                    id="url"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="https://example.com"
                    v-model="form.url"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="notes" value="Notes" />
                <TextareaInput
                    id="notes"
                    class="mt-1 block w-full"
                    v-model="form.notes"
                />
            </div>

            <div class="mt-4">
                <PrimaryButton>Create entry</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
