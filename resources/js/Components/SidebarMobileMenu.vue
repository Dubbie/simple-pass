<script setup>
import SidebarMenu from "./SidebarMenu.vue";

defineProps({
    showMobileMenu: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["close"]);
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div
                v-show="showMobileMenu"
                class="fixed flex inset-0 overflow-y-auto z-50"
                scroll-region
            >
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="showMobileMenu"
                        class="fixed inset-0 transform transition-all"
                        @click="$emit('close')"
                    >
                        <div class="absolute inset-0 bg-gray-900 opacity-75" />
                    </div>
                </transition>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="-translate-x-full"
                    enter-to-class="translate-x-0"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="translate-x-0"
                    leave-to-class="-translate-x-full"
                >
                    <div
                        v-show="showMobileMenu"
                        class="relative mr-16 flex flex-1 flex-col w-full max-w-xs transform transition-all bg-gray-900"
                    >
                        <div
                            class="pt-5 w-16 flex justify-center absolute top-0 left-full"
                        >
                            <button
                                class="p-2.5 -m-2.5"
                                @click="$emit('close')"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6 text-white"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        <SidebarMenu />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
