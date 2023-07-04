<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
defineProps({
    heading: {
        type: String,
    },
});
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <h2 v-if="heading" class="text-white text-2xl font-bold my-6">
            {{ heading }}
        </h2>

        <div
            class="w-full sm:max-w-md mt-6 p-10 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
