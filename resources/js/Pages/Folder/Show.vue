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
import NewPasswordEntryModal from "@/Components/NewPasswordEntryModal.vue";
import EmptyState from "@/Components/Shared/EmptyState.vue";
import PasswordEntryDetailsModal from "@/Components/PasswordEntryDetailsModal.vue";

const props = defineProps({
    folder: {
        type: Object,
        required: true,
    },
});

const refs = {
    showDeleteModal: ref(false),
    showNewFolderModal: ref(false),
    showNewEntryModal: ref(false),
    showPasswordEntryDetailsModal: ref(false),
    selectedEntry: ref(null),
};

const handleDelete = () => {
    router.delete(route("folders.destroy", props.folder), {
        onSuccess: () => {
            refs.showDeleteModal.value = false;
        },
    });
};

const showDetails = (entry) => {
    refs.showPasswordEntryDetailsModal.value = true;
    refs.selectedEntry.value = entry;
};

const hideDetails = () => {
    refs.showPasswordEntryDetailsModal.value = false;
    refs.selectedEntry.value = null;
};
</script>

<template>
    <Head :title="folder.name" />

    <SidebarLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <PageTitle>{{ folder.name }}</PageTitle>
                <div class="flex space-x-3">
                    <PrimaryButton @click="refs.showNewEntryModal.value = true"
                        >New entry</PrimaryButton
                    >
                    <LinkButton @click="refs.showNewFolderModal.value = true"
                        >New folder</LinkButton
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
            <div
                v-if="folder.entries.length === 0"
                class="flex items-center justify-center"
            >
                <EmptyState class="mt-16">
                    <template #icon>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"
                            />
                        </svg>
                    </template>

                    <template #headline>No entries</template>
                    <template #description
                        >How about creating your first entry?</template
                    >

                    <template #action>
                        <PrimaryButton
                            as="button"
                            class="mt-6"
                            @click="refs.showNewEntryModal.value = true"
                            >New entry</PrimaryButton
                        >
                    </template>
                </EmptyState>
            </div>

            <table v-else class="w-full text-sm">
                <thead class="border-b border-gray-700 text-white">
                    <tr class="text-left">
                        <th class="p-3 font-semibold pl-0">Title</th>
                        <th class="p-3 font-semibold">Username</th>
                        <th class="p-3 font-semibold">URL</th>
                        <th class="p-3 font-semibold">Notes</th>
                        <th class="p-3 font-semibold pr-0">Modified</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="entry in folder.entries"
                        :key="entry.id"
                        @click="showDetails(entry)"
                        class="cursor-pointer hover:bg-gray-800"
                    >
                        <td class="p-3 pl-0 text-white font-medium">
                            {{ entry.title }}
                        </td>
                        <td class="p-3">{{ entry.username }}</td>
                        <td class="p-3">{{ entry.url }}</td>
                        <td class="p-3">{{ entry.notes }}</td>
                        <td class="p-3 pr-0">
                            {{ entry.formatted_modified_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
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

        <NewPasswordEntryModal
            :show="refs.showNewEntryModal.value"
            :folderId="folder.id"
            @close="refs.showNewEntryModal.value = false"
        />

        <PasswordEntryDetailsModal
            :show="refs.showPasswordEntryDetailsModal.value"
            :entry="refs.selectedEntry.value"
            @close="hideDetails"
        />
    </SidebarLayout>
</template>
