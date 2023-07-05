<script setup>
import PageTitle from "@/Components/Shared/PageTitle.vue";
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <SidebarLayout>
        <template #header>
            <PageTitle>Dashboard</PageTitle>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-xl font-extrabold text-white">
                Welcome to your vault!
            </h1>
            <p class="mt-2 text-gray-400">
                You can use the sidebar to create your folders where you can
                store your passwords.
            </p>
        </div>
    </SidebarLayout>
</template>
