<script setup>

import {usePage} from "@inertiajs/vue3";
import {getAPIPath} from "@/assets.js";
import {ref} from "vue";
import eventBus from '@/event_bus.js';

const text = ref("");
const sending = ref(false);

async function send() {
    if (text.value.length < 1) {
        return;
    }
    const form = new FormData();
    form.append("post", text.value);
    form.append("user", usePage().props.auth.user.id);
    sending.value = true;
    let data = await fetch(getAPIPath(true) + `/posts/`, {
        method: "POST",
        body: form
    });
    if (!data.ok) {
        return;
    }
    eventBus.value.emit('post-added', await data.json());
    sending.value = false;
    text.value = "";
}
</script>

<template>
    <v-textarea
        v-model="text"
        @click:append="send()"
        append-icon="mdi-send-outline"
        auto-grow
        rows="3"
        no-resize
        counter
        class="px-2 w-full"
        label="What would you like to say..."
        :disabled="sending"
        :loading="sending"
        :rules="[
            () => !!text || 'This field is required'
        ]"
    ></v-textarea>
</template>

