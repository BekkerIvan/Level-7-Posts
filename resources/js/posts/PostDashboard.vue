<script setup>
import { ref } from 'vue'
import {getAPIPath} from "@/assets.js";
import {usePage} from "@inertiajs/vue3";

const loading = ref(true);
const text = ref("");
const sendingPost = ref(false);
let posts = [];

(async () => {
    loading.value = true;
    await fetch(getAPIPath(true)+"/posts/"+usePage().props.auth.user.id).then((response) => {
        if (response.ok) {
            loading.value = false;
            return response.json();
        }
        throw new Error('Something went wrong');
    })
    .then((data) => {
        posts = data;
    })
    .catch((error) => {
        console.log(error)
    });
})()

async function sendPost() {
    await send(getAPIPath(true) + "/posts/");
}

async function sendComment(parentId) {
    await send(getAPIPath(true) + `/posts/${parentId}/`);
}

async function send(path, text) {
    const data = new FormData();
    data.append("post", text.value);
    console.log(data);
    sendingPost.value = true;
    await fetch(path+usePage().props.auth.user.id, {
        method: "POST",
        body: data
    })
    .then((response) => {
        sendingPost.value = false;
        if (response.ok) {
            return response.json();
        }
        throw new Error('Something went wrong');
    })
    .catch((error) => {
        console.log(error)
    });
}
</script>

<template>

    <v-skeleton-loader v-if="loading" type="card"></v-skeleton-loader>
    <div v-else class="flex gap-y-3 flex-wrap">
        <v-card
            v-for="item in posts"
            class="mx-auto"
        >
            <template v-slot:subtitle>
                <div class="flex justify-between items-center">
                    <v-btn size="small" variant="plain">{{ item.first_name }} {{ item.last_name }}</v-btn>
                    <small>{{ item.created_at }}</small>
                </div>
            </template>
            <v-card-text>

                {{ item.post }}
                <v-divider thickness="3"/>
                <v-textarea @click:prepend="sendComment(item.id)"
                            v-model="text"
                            prepend-icon="mdi-send-outline"
                            auto-grow rows="1"
                            no-resize
                            :loading="sendingPost"
                            :disabled="sendingPost"
                            class="p-2"
                            label="Comment...">
                </v-textarea>
                <v-expansion-panels v-if="item.comments.length > 0">
                    <v-expansion-panel
                        title="Comments"
                    >
                    <template v-slot:text>
                        <div v-for="comment in item.comments">
                            <div class="flex justify-between items-center">
                                <v-btn size="small" variant="plain">{{ comment.first_name }} {{ comment.last_name }}</v-btn>
                                <small class="text-disabled">{{ comment.created_at }}</small>
                            </div>
                            {{ comment.post }}
                        </div>
                    </template>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>
        </v-card>
    </div>
</template>
