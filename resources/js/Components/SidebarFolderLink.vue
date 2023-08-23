<script setup>
import { Link } from "@inertiajs/vue3";
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

const iconClasses = computed(() => {
    const base =
        "bg-gray-800 inline-flex items-center justify-center h-6 w-6 rounded-lg border border-gray-700 font-semibold text-[0.625rem]";
    const extras = active.value
        ? "text-white"
        : "text-gray-500 group-hover:text-white";

    return `${base} ${extras}`;
});

const linkBaseClasses =
    "sidebar-folder-link leading-6 text-sm font-semibold gap-x-3 flex p-2 rounded-md group";
const linkExtraClasses = active.value
    ? "text-white"
    : "text-gray-500 hover:text-white hover:bg-gray-800";
</script>

<template>
    <template v-if="folder">
        <Link
            :class="[linkBaseClasses, linkExtraClasses]"
            :href="route('folders.show', folder)"
            :data-folder-id="props.folder.id"
            :data-folder-name="props.folder.name"
        >
            <span :class="iconClasses">
                {{ folder.name.substr(0, 1).toUpperCase() }}
            </span>
            <span>{{ folder.name }}</span>
        </Link>

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
        <Link
            :class="[linkBaseClasses, linkExtraClasses]"
            :href="route('folders.unused')"
        >
            <span :class="iconClasses">O</span>
            <span>Others</span>
        </Link>
    </template>
</template>
