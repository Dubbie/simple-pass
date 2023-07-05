<script setup>
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

const show = ref(true);
const style = computed(() => usePage().props.flash?.bannerStyle || "success");
const message = computed(() => usePage().props.flash?.banner || "");

const hideBanner = () => {
    show.value = false;

    setTimeout(() => {
        usePage().props.flash.banner = null;
        show.value = true;
    }, 750);
};

watch(message, async () => {
    show.value = true;

    if (message.value.length > 0) {
        setTimeout(() => {
            hideBanner();
        }, 2000);
    }
});
</script>

<template>
    <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="transform opacity-0 translate-y-10 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 translate-y-10 scale-95"
    >
        <div
            v-show="show && message"
            class="absolute bottom-4 left-1/2 -translate-x-1/2"
        >
            <div
                class="flex items-center justify-between bg-white p-2 rounded-xl"
            >
                <div class="flex-1 flex items-center">
                    <span class="flex p-1 rounded-full">
                        <svg
                            v-if="style == 'success'"
                            class="h-6 w-6 text-green-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                        <svg
                            v-if="style == 'danger'"
                            class="h-6 w-6 text-red-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                            />
                        </svg>
                    </span>

                    <p class="ml-2 font-medium text-sm text-gray-900">
                        {{ message }}
                    </p>
                </div>

                <div class="shrink-0 sm:ml-6">
                    <button
                        type="button"
                        class="flex p-1 rounded-lg hover:bg-gray-300 focus:outline-none transition"
                        aria-label="Dismiss"
                        @click.prevent="hideBanner"
                    >
                        <svg
                            class="h-5 w-5 text-gray-900"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
