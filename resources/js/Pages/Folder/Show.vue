<script setup>
import PageTitle from "@/Components/Shared/PageTitle.vue";
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    folder: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="folder.name" />

    <SidebarLayout>
        <template #header>
            <PageTitle>{{ folder.name }}</PageTitle>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-500">
            <p>Placeholder.</p>
        </div>
    </SidebarLayout>
</template>
