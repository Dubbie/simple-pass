<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import SelectInput from "./Shared/SelectInput.vue";
import { ref } from "vue";
import { onMounted } from "vue";
import { getFolderOptions } from "@/common-functions";
import FileInput from "@/Components/Shared/FileInput.vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    xml: null,
    folderId: "",
});

const emit = defineEmits(["close"]);

const handleSubmission = () => {
    form.post(route("migrate.keepass.xml"), {
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};

const options = ref([]);

const updateOptions = () => {
    let totalOptions = [];
    let depth = 0;
    usePage().props.folders.roots.forEach((element) => {
        totalOptions = [...totalOptions, ...getFolderOptions(element, depth)];
    });

    options.value = totalOptions;
};

onMounted(() => {
    updateOptions();
});

const handleUpdate = (fileList) => {
    form.xml = fileList[0];
};
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <form @submit.prevent="handleSubmission" class="p-4">
            <ModalTitle>Migrate KeePass XML</ModalTitle>

            <p class="text-gray-400 text-sm mt-2 mb-4">
                Please choose your exported file and select which folder should
                the entries be created in.
            </p>

            <div class="mt-2">
                <InputLabel for="file" value="KeePass XML file" />
                <FileInput
                    :modelValue="form.xml"
                    @update:modelValue="handleUpdate"
                />
            </div>

            <div class="mt-2">
                <InputLabel for="folderId" value="Parent folder" />
                <SelectInput id="folderId" v-model="form.folderId" class="mt-1">
                    <option value="">None</option>
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
                <PrimaryButton type="submit" :disabled="form.processing"
                    >Migrate entries</PrimaryButton
                >
            </div>
        </form>
    </Modal>
</template>
