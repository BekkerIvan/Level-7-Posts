<script setup>
import {onMounted, ref} from "vue";
import eventBus from "@/event_bus.js";
import {getAPIPath} from "@/assets.js";

const isOpen = ref(false)
const text = ref("");
const postId = ref(-1);
const parentId = ref(-1);

onMounted(() => {
    eventBus.value.on('editing', async (id) => {
        const request = await fetch(getAPIPath(true) + `/posts/${id}`);
        if (!request.ok) {
            return;
        }
        const data = await request.json();
        text.value = data.post;
        postId.value = data.id;
        parentId.value = data.parent ?? -1;
        isOpen.value = true;
    });
});

async function updatePost() {
    const form = new FormData();
    form.append("id", postId.value);
    form.append("post", text.value);
    const request = await fetch(getAPIPath(true) + `/posts/update`,{
        method: "POST",
        body: form
    });
    if (!request.ok) {
        return;
    }
    isOpen.value = false;
    const type = parentId.value > 0 ? "comments" : "posts";
    const data = {};
    data[type] = {};
    data[type]["id"] = postId.value;
    data[type]["parent"] = parentId.value;
    eventBus.value.emit('refresh', data);
}
</script>

<template>
    <v-dialog
        v-model="isOpen"
        width="auto"
    >
        <v-card>
            <template v-slot:text>
                <v-textarea
                    :model-value="text"
                    v-model="text"
                    @click:append="updatePost"
                    append-icon="mdi-send-outline"
                    auto-grow
                    rows="1"
                    no-resize
                    class="p-2"
                ></v-textarea>
            </template>
        </v-card>
    </v-dialog>
</template>
