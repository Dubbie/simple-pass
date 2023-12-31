<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/Shared/InputLabel.vue";
import TextInput from "@/Components/Shared/TextInput.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import SelectInput from "./Shared/SelectInput.vue";
import { watch } from "vue";
import { ref } from "vue";
import { onMounted } from "vue";
import { getFolderOptions } from "@/common-functions";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    parentId: {
        type: Number,
    },
});

const form = useForm({
    name: "",
    parent_id: props.parentId ? props.parentId.toString() : "",
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

const options = ref([]);

watch(props, (newData) => {
    if (newData.parentId) {
        updateOptions();

        form.parent_id = newData.parentId.toString();
    }
});

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
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
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
                        v-for="folder in options"
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
