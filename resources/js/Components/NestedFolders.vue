<script setup>
import SidebarFolderLinkNew from "./Shared/SidebarFolderLinkNew.vue";

const props = defineProps({
    folders: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["moveFolderStart"]);

const handleStart = (evt, folder) => {
    evt.dataTransfer.dropEffect = "move";
    evt.dataTransfer.effectAllowed = "move";
    evt.dataTransfer.setData("folderID", folder.id);

    emit("moveFolderStart", evt, folder);
};
</script>

<template>
    <ul class="dragArea">
        <li v-for="folder in folders">
            <SidebarFolderLinkNew
                :folder="folder"
                @dragstart.stop="handleStart($event, folder)"
            />

            <NestedFolders
                :folders="folder.sub_folders"
                v-if="folder.sub_folders.length > 0"
                @move-folder-start="handleStart"
            />
        </li>
    </ul>
</template>

<style scoped>
.dragArea .dragArea {
    padding-left: 1rem;
}
</style>
