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

const showPassword = ref(false);

const passwordInputType = computed(() => {
    return showPassword.value ? "text" : "password";
});

const toggleShowPassword = () => {
    showPassword.value = !showPassword.value;
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
                <div class="relative">
                    <TextInput
                        id="new-password"
                        :type="passwordInputType"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                        v-model="form.password"
                    />

                    <span
                        class="cursor-pointer absolute top-0 py-2.5 pr-3 right-0 text-white text-xs font-bold"
                        @click="toggleShowPassword"
                        >{{ showPassword ? "Hide" : "Show" }}</span
                    >
                </div>
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
                <PrimaryButton>Update entry</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
