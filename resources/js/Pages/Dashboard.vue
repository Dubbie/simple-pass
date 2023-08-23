<script setup>
import PageTitle from "@/Components/Shared/PageTitle.vue";
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
    foldersCount: {
        type: Number,
        required: true,
    },
    entriesCount: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <SidebarLayout>
        <template #header>
            <PageTitle>Dashboard</PageTitle>
        </template>

        <div class="bg-gray-700/10 border-y border-gray-700/50">
            <div class="max-w-7xl mx-auto grid grid-cols-2 sm:grid-cols-4">
                <div class="border-r border-gray-700/50 p-4 sm:px-6 lg:px-8">
                    <p class="text-gray-400 text-sm font-medium leading-7">
                        Number of folders
                    </p>
                    <p class="font-bold text-4xl">
                        {{ foldersCount }}
                    </p>
                </div>
                <div class="p-4 sm:px-6 lg:px-8">
                    <p class="text-gray-400 text-sm font-medium leading-7">
                        Number of entries
                    </p>
                    <p class="font-bold text-4xl">
                        {{ entriesCount }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-xl font-extrabold text-white">
                Welcome to your vault!
            </h1>
            <p class="mt-2 text-gray-500">
                You can use the sidebar to create your folders where you can
                store your passwords.
            </p>
        </div>
    </SidebarLayout>
</template>
