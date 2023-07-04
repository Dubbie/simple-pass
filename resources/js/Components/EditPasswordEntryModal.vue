<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import TextInput from "@/Components/Shared/TextInput.vue";
import TextareaInput from "@/Components/Shared/TextareaInput.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import { watch } from "vue";
import { getPasswordForEntry } from "@/common-functions";
import { ref } from "vue";
import { computed } from "vue";
import PasswordInput from "@/Components/Shared/PasswordInput.vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    entry: {
        type: Object,
    },
});

const form = useForm({
    title: "",
    folder_id: "",
    username: "",
    password: "",
    url: "",
    notes: "",
});

const emit = defineEmits(["close"]);

const handleSubmission = () => {
    form.put(route("password-entries.update", props.entry), {
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};

watch(props, (newData) => {
    if (newData.entry) {
        /// Get the decrypted password
        getPasswordForEntry(newData.entry).then((response) => {
            form.password = response.data.toString();
        });

        form.title = newData.entry.title;
        form.folder_id = newData.entry.folder_id;
        form.username = newData.entry.username;
        form.url = newData.entry.url;
        form.notes = newData.entry.notes;
    } else {
        form.title = "";
        form.folder_id = "";
        form.username = "";
        form.password = "";
        form.url = "";
        form.notes = "";
    }
});
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <form @submit.prevent="handleSubmission" class="p-4" autocomplete="off">
            <ModalTitle>Edit entry</ModalTitle>

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
                <PasswordInput
                    id="new-password"
                    :input-props="{ class: 'mt-1 block w-full' }"
                    v-model="form.password"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="url" value="URL" />
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
                <PrimaryButton>Update entry</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
