<script setup>
import Modal from "@/Components/Shared/Modal.vue";
import ModalTitle from "@/Components/Shared/ModalTitle.vue";
import { copyToClipboard } from "@/common-functions";
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

const copyPassword = () => {
    axios
        .post(route("password-entries.get-password", props.entry))
        .then((response) => {
            console.log(response);
            if (response.status === 200) {
                copyToClipboard(response.data);
                copyPasswordLabel.value = "Copied!";

                setTimeout(() => {
                    copyPasswordLabel.value = "Copy";
                }, 2000);
            }
        })
        .catch((error) => {
            console.log(error.message);
        });
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
                    <div class="col-span-2 flex">
                        <p class="font-medium col-span-2 flex-1">
                            {{ entry.has_password ? "******" : "" }}
                        </p>
                        <p
                            class="text-indigo-500 font-semibold cursor-pointer"
                            v-if="entry.has_password"
                            @click="copyPassword"
                        >
                            {{ copyPasswordLabel }}
                        </p>
                    </div>

                    <p class="font-semibold text-gray-400">URL</p>
                    <p class="font-medium col-span-2">{{ entry.url }}</p>

                    <p class="font-semibold text-gray-400">Notes</p>
                    <p class="font-medium col-span-2">{{ entry.notes }}</p>
                </div>
            </div>
        </div>
    </Modal>
</template>
