<script setup>
import SidebarMenu from "@/Components/SidebarMenu.vue";

const props = defineProps({
    showMobileMenu: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["close"]);
</script>

<template>
    <div
        class="hidden xl:flex xl:flex-col xl:w-72 xl:z-40 xl:fixed xl:inset-y-0"
    >
        <SidebarMenu />
    </div>
</template>
