<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="flex items-center justify-center bg-gray-900 min-h-screen min-w-screen"
    >
        <div class="w-64">
            <h1 class="font-extrabold text-white">SimplePass</h1>

            <div>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="font-semibold text-gray-500 hover:text-white focus:text-white"
                    >Dashboard</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="text-sm font-semibold text-gray-500 hover:text-white focus:text-white"
                        >Log in</Link
                    >

                    <Link
                        :href="route('register')"
                        class="text-sm ml-4 font-semibold text-gray-500 hover:text-white focus:text-white"
                        >Register</Link
                    >
                </template>
            </div>
        </div>
    </div>
</template>
