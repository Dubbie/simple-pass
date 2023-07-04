<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { copyToClipboard, getPasswordForEntry } from "@/common-functions";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    entry: {
        type: Object,
    },
});

const copyPasswordLabel = ref("Copy");
const showPassword = ref(false);
const actualPassword = ref(null);

const copyPassword = async () => {
    const response = await getPasswordForEntry(props.entry);
    copyToClipboard(response.data);
    copyPasswordLabel.value = "Copied!";
    setTimeout(() => {
        copyPasswordLabel.value = "Copy";
    }, 2000);
};

const handleShowPassword = async () => {
    if (!showPassword.value) {
        const response = await getPasswordForEntry(props.entry);
        actualPassword.value = response.data;
    } else {
        actualPassword.value = null;
    }

    showPassword.value = !showPassword.value;
};
</script>

<template>
    <Modal :show="show" max-width="md" @close="$emit('close')">
        <div class="p-8 text-white">
            <ModalTitle>Entry details</ModalTitle>

            <div class="mt-8">
                <div class="text-sm grid grid-cols-3 gap-3">
                    <p class="font-semibold text-gray-400">Title</p>
                    <p class="font-medium col-span-2">{{ entry.title }}</p>

                    <p class="font-semibold text-gray-400">Username</p>
                    <p class="font-medium col-span-2">{{ entry.username }}</p>

                    <p class="font-semibold text-gray-400">Password</p>
                    <div class="col-span-2 flex" v-if="entry.has_password">
                        <p class="font-medium col-span-2 flex-1">
                            {{ showPassword ? actualPassword : "******" }}
                        </p>

                        <div class="flex space-x-3">
                            <p
                                class="text-indigo-500 font-semibold cursor-pointer"
                                @click="handleShowPassword"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                    v-if="showPassword"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                                    />
                                </svg>
                            </p>
                            <p
                                class="text-indigo-500 font-semibold cursor-pointer"
                                @click="copyPassword"
                            >
                                {{ copyPasswordLabel }}
                            </p>
                        </div>
                    </div>
                    <p class="col-span-2" v-else></p>

                    <p class="font-semibold text-gray-400">URL</p>
                    <p class="font-medium col-span-2">{{ entry.url }}</p>

                    <p class="font-semibold text-gray-400">Notes</p>
                    <p class="font-medium col-span-2">{{ entry.notes }}</p>
                </div>
            </div>
        </div>
    </Modal>
</template>
