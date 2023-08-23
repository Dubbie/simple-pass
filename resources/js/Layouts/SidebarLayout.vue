<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AppSidebar from "@/Components/AppSidebar.vue";
import AppSearchbar from "@/Components/AppSearchbar.vue";
import SidebarMobileMenu from "@/Components/SidebarMobileMenu.vue";
import AppBanner from "@/Components/Shared/AppBanner.vue";

defineProps({
    title: String,
});

const showingMobileMenu = ref(false);

const logout = () => {
    router.post(route("logout"));
};

const handleMobileMenu = () => {
    console.log("Toggling mobile menu");
    showingMobileMenu.value = !showingMobileMenu.value;
};
</script>

<template>
    <div class="overflow-y-auto h-screen bg-gray-900">
        <Head :title="title" />

        <AppBanner />

        <div>
            <!-- Sidebar -->
            <AppSidebar @close="handleMobileMenu" />

            <!-- Page Content -->
            <div class="xl:pl-72">
                <AppSearchbar @toggle-menu="handleMobileMenu"></AppSearchbar>

                <main class="text-white">
                    <!-- Page Heading -->
                    <header v-if="$slots.header">
                        <div
                            class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"
                        >
                            <slot name="header" />
                        </div>
                    </header>
                    <slot />
                </main>
            </div>
        </div>

        <!-- <SidebarMobileMenu
            :showMobileMenu="showingMobileMenu"
            @close="handleMobileMenu"
        /> -->
    </div>
</template>
