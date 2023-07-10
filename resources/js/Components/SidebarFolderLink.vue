<script setup>
import SidebarLink from "@/Components/SidebarLink.vue";
import { computed } from "vue";

const props = defineProps({
    folder: {
        type: Object,
    },
});

const active = computed(() => {
    if (props.folder) {
        return route().current("folders.show", props.folder);
    }

    return route().current("folders.unused");
});
</script>

<template>
    <template v-if="folder">
        <SidebarLink
            class="sidebar-folder-link"
            :href="route('folders.show', folder)"
            :active="active"
            :key="active"
            :data-folder-id="props.folder.id"
            :data-folder-name="props.folder.name"
        >
            <template #icon>
                <span
                    class="bg-gray-800 inline-flex items-center justify-center h-5 w-5 rounded border border-gray-700 text-gray-500 font-semibold text-[0.625rem] group-hover:text-gray-200"
                >
                    {{ folder.name.substr(0, 1).toUpperCase() }}
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

    <template v-else>
        <SidebarLink
            class="sidebar-folder-link"
            :href="route('folders.unused')"
            :active="active"
            :key="active"
        >
            <template #icon>
                <span
                    class="bg-gray-800 inline-flex items-center justify-center h-5 w-5 rounded border border-gray-700 text-gray-500 font-semibold text-[0.625rem] group-hover:text-gray-200"
                    >O</span
                >
            </template>
            <span>Others</span>
        </SidebarLink>
    </template>
</template>
