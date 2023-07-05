<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link :href="route('dashboard')">
        <p class="flex text-xl items-center font-bold">
            <span class="text-blue-500 tracking-tighter mr-2">∗∗∗</span>
            <span class="text-indigo-600">SIMPLE</span>
            <span class="text-blue-500">PASS</span>
        </p>
    </Link>
</template>
