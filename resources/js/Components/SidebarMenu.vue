<script setup>
import SidebarLink from "@/Components/SidebarLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import SidebarHeader from "@/Components/Shared/SidebarHeader.vue";
import LinkButton from "./Shared/LinkButton.vue";
import NewFolderModal from "./NewFolderModal.vue";
import { ref } from "vue";
import SidebarFolderLink from "./SidebarFolderLink.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const refs = {
    showNewFolderModal: ref(false),
};

const handleNewFolder = () => {
    refs.showNewFolderModal.value = true;
};

const page = usePage();

const folders = computed(() => page.props.folders.roots);
const location = computed(() => page.props.ziggy.location);
</script>

<template>
    <div
        class="flex flex-grow flex-col px-6 overflow-y-auto gap-y-5 bg-black/10 border-r border-gray-700"
    >
        <div class="h-16 flex items-center flex-shrink-0">
            <ApplicationLogo class="h-8" />
        </div>

        <div class="flex flex-col flex-1">
            <ul class="flex flex-col flex-1 gap-7">
                <!-- Main menu -->
                <li>
                    <ul class="space-y-1 -mx-2">
                        <li>
                            <SidebarLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard*')"
                            >
                                <template #icon>
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
                                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                                        />
                                    </svg>
                                </template>
                                Dashboard
                            </SidebarLink>
                        </li>
                    </ul>
                </li>

                <!-- Folders -->
                <li>
                    <ul class="space-y-1 -mx-2">
                        <li>
                            <SidebarHeader>Your folders</SidebarHeader>
                        </li>
                        <p
                            v-if="folders.length == 0"
                            class="text-gray-600 font-semibold text-sm"
                        >
                            No Folders
                        </p>
                        <template v-else>
                            <template
                                v-for="folder in folders"
                                :key="folder.id"
                            >
                                <li>
                                    <SidebarFolderLink :folder="folder" />
                                </li>
                            </template>
                        </template>

                        <li>
                            <SidebarFolderLink :folder="null" :key="location" />
                        </li>

                        <li>
                            <LinkButton @click="handleNewFolder"
                                >+ New folder</LinkButton
                            >
                        </li>
                    </ul>
                </li>

                <!-- User -->
                <li class="-mx-6 mt-auto">
                    <Dropdown align="bottom-left">
                        <template #trigger>
                            <a
                                href="#!"
                                class="text-white font-semibold leading-6 text-sm py-3 px-6 flex items-center gap-x-4 hover:bg-gray-800"
                            >
                                <!-- <img
                                    src="http://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    class="h-8 rounded-full bg-gray-800"
                                    alt=""
                                /> -->
                                <span>{{ $page.props.auth.user.name }}</span>
                            </a>
                        </template>

                        <template #content>
                            <!-- <DropdownLink :href="route('profile.edit')"
                                >Profil</DropdownLink
                            > -->
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                                >Logout</DropdownLink
                            >
                        </template>
                    </Dropdown>
                </li>
            </ul>
        </div>
    </div>

    <NewFolderModal
        :show="refs.showNewFolderModal.value"
        @close="refs.showNewFolderModal.value = false"
    />
</template>
