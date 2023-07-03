<script setup>
import { onMounted } from "vue";
import { ref } from "vue";

defineProps({
    message: {
        type: String,
        required: true,
    },
});

const show = ref(false);
const span = ref(null);
const tooltipClasses = ref("");
const arrowClasses = ref("");

const updateAlignmentClasses = () => {
    const rect = span.value.getBoundingClientRect();
    if (rect.left > document.body.clientWidth / 2) {
        tooltipClasses.value = "right-0 translate-x-3.5 translate-y-2";
        arrowClasses.value = "right-0 -translate-x-4";
    } else {
        tooltipClasses.value = "-translate-x-3.5 translate-y-2";
        arrowClasses.value = "";
    }
};

onMounted(() => {
    window.addEventListener("resize", () => {
        updateAlignmentClasses();
    });
    updateAlignmentClasses();
});
</script>

<template>
    <div class="relative">
        <span
            ref="span"
            @mouseenter="show = true"
            @mouseleave="show = false"
            @click="show = !show"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5 text-gray-500"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                />
            </svg>
        </span>

        <transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="show"
                class="bg-black/70 px-4 py-3 rounded-lg w-max max-w-xs absolute z-50 sm:max-w-lg"
                :class="tooltipClasses"
                @click="show = !show"
                @mouseenter="show = true"
                @mouseleave="show = false"
            >
                <span
                    class="absolute top-0 -translate-y-full border-black/70 border-8 border-l-transparent border-r-transparent border-t-transparent"
                    :class="arrowClasses"
                ></span>
                <p class="text-white leading-6 text-sm font-medium">
                    {{ message }}
                </p>
            </div>
        </transition>
    </div>
</template>
