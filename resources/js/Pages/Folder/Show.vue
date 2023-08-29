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
import MovePasswordEntryModal from "@/Components/MovePasswordEntryModal.vue";
import axios from "axios";
import { isMobile } from "@/common-functions";
import { onMounted } from "vue";
import DeleteFolderModal from "@/Components/DeleteFolderModal.vue";

const props = defineProps({
    folder: {
        type: Object,
    },
    entries: {
        type: Array,
    },
});

const refs = {
    entries: ref([]),
    showDeleteFolderModal: ref(false),
    showNewFolderModal: ref(false),
    showNewEntryModal: ref(false),
    showEditEntryModal: ref(false),
    showDeleteEntryModal: ref(false),
    showPasswordEntryDetailsModal: ref(false),
    showConfirmMoveEntryModal: ref(false),
    showMoveEntryModal: ref(false),
    selectedEntry: ref(null),
    selectedEntryId: ref(null),
    newFolder: ref(null),
    isMobile: ref(isMobile()),
    title: ref("Unused"),
    folderId: ref(null),
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
        show("showConfirmMoveEntryModal");
    }
};

const handleMoveEntry = () => {
    router.put(
        route("password-entries.move"),
        {
            password_entry_id: refs.selectedEntryId.value,
            folder_id: refs.newFolder.value.id,
        },
        {
            onSuccess: () => {
                hide("showConfirmMoveEntryModal");
            },
        }
    );
};

const handleChange = async (event) => {
    if ("moved" in event) {
        try {
            const response = await axios.request({
                url: route("password-entries.update-order"),
                data: {
                    entries: refs.entries.value,
                },
                method: "PUT",
            });
        } catch (error) {
            console.error(error);
        }
    }
};

watch(props, (newProps) => {
    updateData();
});

const updateData = () => {
    if (props.folder) {
        refs.entries.value = props.folder.entries;
        refs.title.value = props.folder.name;
        refs.folderId.value = props.folder.id;
    } else {
        refs.entries.value = props.entries;
    }
};

onMounted(() => {
    updateData();

    window.addEventListener("resize", () => {
        refs.isMobile.value = isMobile();
    });
});
</script>

<template>
    <Head :title="refs.title.value" />

    <SidebarLayout>
        <template #header>
            <div
                class="flex flex-col justify-between sm:items-center sm:flex-row"
            >
                <PageTitle>{{ refs.title.value }}</PageTitle>
                <div class="mt-3 sm:mt-0 flex space-x-2">
                    <LinkButton
                        color="secondary"
                        @click="refs.showNewFolderModal.value = true"
                        >New folder</LinkButton
                    >
                    <LinkButton
                        color="secondary"
                        @click="show('showDeleteFolderModal')"
                        >Delete folder</LinkButton
                    >
                    <PrimaryButton @click="refs.showNewEntryModal.value = true"
                        >New entry</PrimaryButton
                    >
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-500">
            <div
                v-if="refs.entries.value.length === 0"
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

            <div class="block max-w-full" v-else>
                <table class="text-sm w-full table-fixed">
                    <thead class="border-b border-gray-700 text-white">
                        <tr class="text-left">
                            <th class="p-3 w-12 sm:pl-0"></th>
                            <th class="p-3 font-semibold">Title</th>
                            <th class="p-3 font-semibold hidden md:table-cell">
                                Username
                            </th>
                            <th class="p-3 font-semibold hidden md:table-cell">
                                URL
                            </th>
                            <th class="p-3 font-semibold hidden md:table-cell">
                                Notes
                            </th>
                            <th
                                class="p-3 font-semibold text-center hidden md:table-cell"
                            >
                                Modified
                            </th>
                            <th class="p-3 font-semibold sm:pr-0"></th>
                        </tr>
                    </thead>
                    <draggable
                        v-model="refs.entries.value"
                        item-key="id"
                        tag="tbody"
                        placeholder="dashed"
                        chosenClass="opacity-50"
                        handle=".handle"
                        :disabled="refs.isMobile.value"
                        @change="handleChange"
                        @end="checkMove"
                    >
                        <template #item="{ element: entry }">
                            <tr
                                class="hover:bg-gray-800 group"
                                :data-entry-id="entry.id"
                            >
                                <td class="p-3 text-white font-medium">
                                    <span
                                        class="handle cursor-pointer text-white/50"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-6 h-6"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                                            />
                                        </svg>
                                    </span>
                                </td>
                                <td class="p-3 text-white font-medium truncate">
                                    {{ entry.title }}
                                </td>
                                <td class="p-3 hidden md:table-cell">
                                    {{ entry.username }}
                                </td>
                                <td class="p-3 hidden truncate md:table-cell">
                                    {{ entry.url }}
                                </td>
                                <td class="p-3 hidden truncate md:table-cell">
                                    {{ entry.notes }}
                                </td>
                                <td
                                    class="p-3 hidden text-center truncate md:table-cell"
                                >
                                    {{ entry.formatted_modified_at }}
                                </td>
                                <td class="p-3 sm:pr-0">
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
                                                        'showMoveEntryModal',
                                                        entry
                                                    )
                                                "
                                                >Move</DropdownLink
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
        </div>

        <DeleteFolderModal
            :folder="folder"
            :show="refs.showDeleteFolderModal.value"
            @close="hide('showDeleteFolderModal')"
        />

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
            :parentId="refs.folderId.value"
            @close="refs.showNewFolderModal.value = false"
        />

        <NewPasswordEntryModal
            :show="refs.showNewEntryModal.value"
            :folderId="refs.folderId.value"
            @close="refs.showNewEntryModal.value = false"
        />

        <EditPasswordEntryModal
            :show="refs.showEditEntryModal.value"
            :entry="refs.selectedEntry.value"
            @close="hide('showEditEntryModal')"
        />

        <MovePasswordEntryModal
            :show="refs.showMoveEntryModal.value"
            :entry="refs.selectedEntry.value"
            @close="hide('showMoveEntryModal')"
        />

        <PasswordEntryDetailsModal
            :show="refs.showPasswordEntryDetailsModal.value"
            :entry="refs.selectedEntry.value"
            @close="hide('showPasswordEntryDetailsModal')"
        />

        <ConfirmModal
            :show="refs.showConfirmMoveEntryModal.value"
            :callback="handleMoveEntry"
            @close="hide('showConfirmMoveEntryModal')"
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
