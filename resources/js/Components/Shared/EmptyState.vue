<template>
    <div class="flex flex-col items-center">
        <span class="w-12 h-12 text-gray-400">
            <slot name="icon" />
        </span>

        <p class="font-semibold text-white text-sm mt-4">
            <slot name="headline" />
        </p>

        <p class="text-sm mt-1 text-gray-500">
            <slot name="description" />
        </p>

        <div v-if="$slots.action">
            <slot name="action" />
        </div>
    </div>
</template>
