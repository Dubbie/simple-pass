<script setup>
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import PageTitle from "@/Components/Shared/PageTitle.vue";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import NewFolderModal from "@/Components/NewFolderModal.vue";
import LinkButton from "@/Components/Shared/LinkButton.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import NewPasswordEntryModal from "@/Components/NewPasswordEntryModal.vue";
import EditPasswordEntryModal from "@/Components/EditPasswordEntryModal.vue";
import EmptyState from "@/Components/Shared/EmptyState.vue";
import DeleteModal from "@/Components/Shared/DeleteModal.vue";
import ConfirmModal from "@/Components/Shared/ConfirmModal.vue";
import PasswordEntryDetailsModal from "@/Components/PasswordEntryDetailsModal.vue";
import DotDropdown from "@/Components/Shared/DotDropdown.vue";
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import draggable from "vuedraggable";
import { watch } from "vue";

const props = defineProps({
    folder: {
        type: Object,
        required: true,
    },
});

const refs = {
    entries: ref(props.folder.entries),
    showDeleteFolderModal: ref(false),
    showNewFolderModal: ref(false),
    showNewEntryModal: ref(false),
    showEditEntryModal: ref(false),
    showDeleteEntryModal: ref(false),
    showPasswordEntryDetailsModal: ref(false),
    showMoveEntryModal: ref(false),
    selectedEntry: ref(null),
    selectedEntryId: ref(null),
    newFolder: ref(null),
};

const handleDeleteFolder = () => {
    router.delete(route("folders.destroy", props.folder), {
        onSuccess: () => {
            hide("showDeleteFolderModal");
        },
    });
};

const handleDeleteEntry = () => {
    router.delete(route("password-entries.destroy", refs.selectedEntry.value), {
        onSuccess: () => {
            hide("showDeleteEntryModal");
        },
    });
};

const show = (refName, entry = null) => {
    if (entry) {
        refs.selectedEntry.value = entry;
    }

    refs[refName].value = true;
};

const hide = (refName) => {
    refs[refName].value = false;
    refs.selectedEntry.value = null;
};

const checkMove = async (evt) => {
    refs.newFolder.value = null;
    const hoveredAt = document.elementFromPoint(
        evt.originalEvent.x,
        evt.originalEvent.y
    );

    const folderLink = hoveredAt.closest(".sidebar-folder-link");

    if (folderLink) {
        refs.newFolder.value = {
            id: folderLink.dataset.folderId,
            name: folderLink.dataset.folderName,
        };
        refs.selectedEntryId.value = evt.item.dataset.entryId;
        show("showMoveEntryModal");
    }
};

const handleMoveEntry = () => {
    router.post(
        route("password-entries.move"),
        {
            password_entry_id: refs.selectedEntryId.value,
            folder_id: refs.newFolder.value.id,
        },
        {
            onSuccess: () => {
                hide("showMoveEntryModal");
            },
        }
    );
};

watch(props, (newProps) => {
    refs.entries.value = newProps.folder.entries;
});
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
                        @click="show('showDeleteFolderModal')"
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
                        <th class="p-3 font-semibold">Modified</th>
                        <th class="p-3 font-semibold pr-0"></th>
                    </tr>
                </thead>
                <draggable
                    v-model="refs.entries.value"
                    item-key="id"
                    tag="tbody"
                    @end="checkMove"
                >
                    <template #item="{ element: entry }">
                        <tr
                            class="hover:bg-gray-800 group"
                            :data-entry-id="entry.id"
                        >
                            <td class="p-3 pl-0 text-white font-medium">
                                {{ entry.title }}
                            </td>
                            <td class="p-3">{{ entry.username }}</td>
                            <td class="p-3">{{ entry.url }}</td>
                            <td class="p-3">{{ entry.notes }}</td>
                            <td class="p-3">
                                {{ entry.formatted_modified_at }}
                            </td>
                            <td class="p-3 pr-0">
                                <div
                                    class="flex items-center justify-end space-x-1"
                                >
                                    <SecondaryButton
                                        size="xs"
                                        @click="
                                            show(
                                                'showPasswordEntryDetailsModal',
                                                entry
                                            )
                                        "
                                        >Details</SecondaryButton
                                    >
                                    <DotDropdown class="pr-2">
                                        <DropdownLink
                                            @click="
                                                show(
                                                    'showEditEntryModal',
                                                    entry
                                                )
                                            "
                                            >Edit</DropdownLink
                                        >
                                        <DropdownLink
                                            @click="
                                                show(
                                                    'showDeleteEntryModal',
                                                    entry
                                                )
                                            "
                                            >Delete</DropdownLink
                                        >
                                    </DotDropdown>
                                </div>
                            </td>
                        </tr>
                    </template>
                </draggable>
            </table>
        </div>

        <DeleteModal
            :show="refs.showDeleteFolderModal.value"
            :callback="handleDeleteFolder"
            @close="hide('showDeleteFolderModal')"
        >
            <template #title>Delete Folder</template>
            <template #body
                >Are you sure you want to delete this folder?</template
            >
        </DeleteModal>

        <DeleteModal
            :show="refs.showDeleteEntryModal.value"
            :callback="handleDeleteEntry"
            @close="hide('showDeleteEntryModal')"
        >
            <template #title>Delete Entry</template>
            <template #body
                >Are you sure you want to delete this entry?</template
            >
        </DeleteModal>

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

        <EditPasswordEntryModal
            :show="refs.showEditEntryModal.value"
            :entry="refs.selectedEntry.value"
            @close="hide('showEditEntryModal')"
        />

        <PasswordEntryDetailsModal
            :show="refs.showPasswordEntryDetailsModal.value"
            :entry="refs.selectedEntry.value"
            @close="hide('showPasswordEntryDetailsModal')"
        />

        <ConfirmModal
            :show="refs.showMoveEntryModal.value"
            :callback="handleMoveEntry"
            @close="hide('showMoveEntryModal')"
        >
            <template #title>Move entry</template>
            <template #body
                >Are you sure you want to move this entry?<br />It will be moved
                to the following folder:
                <b>{{ refs.newFolder.value.name ?? "" }}</b></template
            >
        </ConfirmModal>
    </SidebarLayout>
</template>
