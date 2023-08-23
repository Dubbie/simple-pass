<script setup>
import SidebarFolderLinkNew from "./Shared/SidebarFolderLinkNew.vue";

const props = defineProps({
    folder: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <SidebarFolderLinkNew :folder="folder" />

    <div v-if="folder.sub_folders.length > 0">
        <FolderGroup
            :folder="subFolder"
            v-for="subFolder in folder.sub_folders"
            :key="subFolder.id"
        />
    </div>
</template>
