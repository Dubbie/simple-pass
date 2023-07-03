<script setup>
import { ref } from "vue";
import SidebarLink from "@/Components/SidebarLink.vue";

const props = defineProps({
    folder: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <SidebarLink
        :href="route('folders.show', folder)"
        :active="route().current('folders.show', folder)"
    >
        <template #icon>
            <span
                class="bg-gray-800 inline-flex items-center justify-center h-5 w-5 rounded border border-gray-700 text-gray-500 font-semibold text-[0.625rem]"
            >
                {{ folder.name.substr(0, 1) }}
            </span>
        </template>
        <span>{{ folder.name }}</span>
    </SidebarLink>

    <span v-if="folder.sub_folders.length > 0" class="block ml-4 mt-1">
        <ul class="space-y-1">
            <template v-for="subFolder in folder.sub_folders">
                <li>
                    <SidebarFolderLink :folder="subFolder" />
                </li>
            </template>
        </ul>
    </span>
</template>
