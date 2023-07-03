<script setup>
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import PageTitle from "@/Components/Shared/PageTitle.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import DangerButton from "@/Components/Shared/DangerButton.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import NewFolderModal from "@/Components/NewFolderModal.vue";
import LinkButton from "@/Components/Shared/LinkButton.vue";
import Modal from "@/Components/Shared/Modal.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    folder: {
        type: Object,
        required: true,
    },
});

const refs = {
    showDeleteModal: ref(false),
    showNewFolderModal: ref(false),
};

const handleDelete = () => {
    router.delete(route("folders.destroy", props.folder), {
        onSuccess: () => {
            refs.showDeleteModal.value = false;
        },
    });
};
</script>

<template>
    <Head :title="folder.name" />

    <SidebarLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <PageTitle>{{ folder.name }}</PageTitle>
                <div class="flex space-x-3">
                    <PrimaryButton @click="refs.showNewFolderModal.value = true"
                        >New folder</PrimaryButton
                    >
                    <LinkButton
                        color="secondary"
                        @click="refs.showDeleteModal.value = true"
                        >Delete</LinkButton
                    >
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-500">
            <p>Placeholder.</p>
        </div>

        <Modal
            :show="refs.showDeleteModal.value"
            @close="refs.showDeleteModal.value = false"
        >
            <div class="p-4">
                <ModalTitle>Delete Folder</ModalTitle>
                <p class="text-sm text-gray-400">
                    Are you sure you want to delete the folder? This cannot be
                    undone.
                </p>
                <div class="mt-4 flex items-center space-x-4">
                    <DangerButton @click="handleDelete"
                        >Yes, delete</DangerButton
                    >
                    <LinkButton
                        color="secondary"
                        @click="refs.showDeleteModal.value = false"
                        >Cancel</LinkButton
                    >
                </div>
            </div>
        </Modal>

        <NewFolderModal
            :show="refs.showNewFolderModal.value"
            :parentId="folder.id"
            @close="refs.showNewFolderModal.value = false"
        />
    </SidebarLayout>
</template>
