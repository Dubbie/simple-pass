<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import TextInput from "@/Components/Shared/TextInput.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import SelectInput from "./Shared/SelectInput.vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    name: "",
    parent_id: "",
});

const emit = defineEmits(["close"]);

const handleSubmission = () => {
    form.post(route("folders.store"), {
        onSuccess: () => {
            form.reset("name");
            emit("close");
        },
    });
};
</script>

<template>
    <Modal :show="show" max-width="lg" @close="$emit('close')">
        <form @submit.prevent="handleSubmission" class="p-4">
            <ModalTitle>New Folder</ModalTitle>

            <div class="mt-2">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    type="text"
                    placeholder="Eg. Personal"
                    class="mt-1 block w-full"
                    autocomplete="off"
                    v-model="form.name"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="parent_id" value="Parent folder" />
                <SelectInput
                    id="parent_id"
                    v-model="form.parent_id"
                    class="mt-1"
                >
                    <option value="">None</option>
                    <option
                        v-for="folder in $page.props.folders"
                        :key="folder.id"
                        :value="folder.id"
                    >
                        {{ folder.name }}
                    </option>
                </SelectInput>
            </div>

            <div class="mt-4">
                <PrimaryButton>Create folder</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
