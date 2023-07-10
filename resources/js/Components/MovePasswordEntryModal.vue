<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import { onMounted, watch } from "vue";
import { getAllFolderOptions } from "@/common-functions";
import { ref } from "vue";
import SelectInput from "./Shared/SelectInput.vue";

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
    folder_id: null,
    password_entry_id: null,
});

const emit = defineEmits(["close"]);
const options = ref([]);

const handleSubmission = () => {
    form.put(route("password-entries.move"), {
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};

watch(props, (newData) => {
    if (newData.entry) {
        if (form.folder_id) {
            form.folder_id = newData.entry.folder_id.toString();
        }

        form.password_entry_id = newData.entry.id;
    } else {
        form.folder_id = null;
        form.password_entry_id = null;
    }
});

onMounted(() => {
    options.value = getAllFolderOptions();
});
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <form @submit.prevent="handleSubmission" class="p-4" autocomplete="off">
            <ModalTitle>Move entry</ModalTitle>

            <p class="text-sm text-gray-500">
                Where would you like to move the entry to?
            </p>

            <div class="mt-2">
                <InputLabel
                    for="folder_id"
                    class="sr-only"
                    value="New folder"
                />
                <SelectInput
                    id="folder_id"
                    v-model="form.folder_id"
                    class="mt-1"
                >
                    <option
                        v-for="folder in options"
                        :key="folder.id"
                        :value="folder.id"
                    >
                        {{ folder.name }}
                    </option>
                </SelectInput>
            </div>

            <div class="mt-4">
                <PrimaryButton>Move entry</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
