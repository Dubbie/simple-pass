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

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-gray-900 overflow-hidden border border-gray-700 sm:rounded-lg"
                >
                    <div class="p-6 text-white-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </SidebarLayout>
</template>
