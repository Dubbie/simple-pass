<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const form = useForm({
    query: "",
});

let timer = null;
const open = ref(false);
const searchResults = {
    folders: ref([]),
    entries: ref([]),
};

defineEmits(["toggle-menu"]);

const submitSearch = async () => {
    if (form.query.length === 0) {
        searchResults.folders.value = [];
        searchResults.entries.value = [];
        open.value = false;
        return;
    }

    const response = await fetchQuery();
    searchResults.folders.value = response.data.folders;
    searchResults.entries.value = response.data.entries;
    open.value = true;
};

const handleSearchInput = () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        submitSearch();
    }, 300);
};

const handleOpening = () => {
    if (
        searchResults.entries.value.length > 0 ||
        searchResults.folders.value.length > 0
    ) {
        open.value = true;
    }
};

const fetchQuery = async () => {
    try {
        return await axios.get(route("search", { query: form.query }));
    } catch (e) {
        usePage().props.flash.banner =
            "Something went wrong while searching: " + e.message;
        usePage().props.flash.bannerStyle = "danger";
    }
};
</script>

<template>
    <div
        class="flex flex-shrink-0 h-16 items-center border-b border-gray-700 gap-x-4 px-4 md:px-6 md:gap-x-6 lg:px-8"
    >
        <div class="flex flex-1 self-stretch gap-4 lg:gap-6">
            <button @click="$emit('toggle-menu')" class="xl:hidden">
                <span class="sr-only">Close sidebar</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-white"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>
            </button>

            <!-- Full Screen Dropdown Overlay -->
            <div
                v-show="open"
                class="fixed inset-0 z-40"
                @click="open = false"
            ></div>

            <form @submit.prevent="submitSearch" class="relative z-50 flex-1">
                <label for="search-field" class="sr-only">Search</label>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 pointer-events-none absolute inset-y-0 left-0 h-full text-gray-400"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                    />
                </svg>
                <input
                    id="search-field"
                    type="text"
                    v-model="form.query"
                    autocomplete="off"
                    class="bg-gray-900 block pr-0 pl-6 text-white border-0 w-full h-full md:text-sm focus:ring-0"
                    @keydown="handleSearchInput"
                    @click="handleOpening"
                    placeholder="Search..."
                />

                <div
                    class="z-50 absolute top-full inset-x-0 -mx-8 bg-gray-800 border-y border-gray-700 shadow"
                    v-show="open"
                >
                    <div
                        v-if="searchResults.folders.value.length > 0"
                        class="px-4 mb-4"
                    >
                        <p
                            class="text-xs text-gray-500 font-semibold mt-4 px-4 mb-2"
                        >
                            Folders
                        </p>
                        <Link
                            v-for="folder in searchResults.folders.value"
                            :href="route('folders.show', folder.id)"
                            :key="folder.id"
                        >
                            <p
                                class="text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-gray-700 cursor-pointer"
                            >
                                {{ folder.name }}
                            </p>
                        </Link>
                    </div>

                    <div
                        v-if="searchResults.entries.value.length > 0"
                        class="px-4 mb-4"
                    >
                        <p
                            class="text-xs text-gray-500 font-semibold mt-4 px-4 mb-2"
                        >
                            Entries
                        </p>
                        <Link
                            v-for="entry in searchResults.entries.value"
                            :href="route('folders.show', entry.folder_id)"
                            :key="entry.id"
                        >
                            <p
                                class="grid grid-cols-4 text-gray-500 text-sm font-semibold py-2 px-4 rounded-md hover:bg-gray-700 cursor-pointer"
                            >
                                <span class="text-white">{{
                                    entry.title
                                }}</span>
                                <span>{{ entry.username }}</span>
                                <span class="truncate whitespace-nowrap">{{
                                    entry.url
                                }}</span>
                            </p>
                        </Link>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
