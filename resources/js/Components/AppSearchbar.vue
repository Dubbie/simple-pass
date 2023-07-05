<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    query: "",
});

defineEmits(["toggle-menu"]);

const submitSearch = () => {
    console.log(form.query);
};
</script>

<template>
    <div
        class="flex flex-shrink-0 h-16 items-center sticky border-b border-gray-700 gap-x-4 px-4 md:px-6 md:gap-x-6 lg:px-8"
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

            <form @prevent.submit="submitSearch" class="flex relative flex-1">
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
                    class="bg-gray-900 block pr-0 pl-6 text-gray-400 border-0 w-full h-full md:text-sm focus:ring-0"
                    disabled
                    placeholder="Search..."
                />
            </form>
        </div>
    </div>
</template>
