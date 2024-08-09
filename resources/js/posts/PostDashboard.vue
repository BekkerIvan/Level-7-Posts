<script setup>
import { ref, reactive, onMounted } from 'vue';
import { getAPIPath } from "@/assets.js";
import { usePage } from "@inertiajs/vue3";
import eventBus from "@/event_bus.js";
import PostHeader from "@/posts/PostHeader.vue";
import Comment from "@/posts/Comment.vue";
import PostText from "@/posts/PostText.vue";

const loadingPosts = ref(false);
const sendingComment = ref({});
const posts = ref([]);
const comments = ref({});
const commentTextareas = reactive({});

onMounted(async () => {
    await fetchPosts();

    eventBus.value.on('post-added', (newPost) => {
        resetComments(newPost.id);
        posts.value.unshift(newPost);
    });

    eventBus.value.on('refresh', async (data) => {
        const type = Object.keys(data)[0];
        switch (type) {
            case "posts":
                await fetchPosts();
                break;
            case "comments": {
                await fetchComments(data[type].parent);
                break;
            }
        }
    });
});

function setCommentsLoading(postId, isLoading) {
    if (postId === undefined) {
        Object.keys(comments.value).forEach(index => {
            comments.value[index].loading = isLoading;
        });
    } else {
        comments.value[postId].loading = isLoading;
    }
}
function resetComments(postId) {
    if (postId === undefined) {
        posts.value.forEach(post => {
            sendingComment.value[post.id] = false;
            comments.value[post.id] = {
                loading: false,
                comments: []
            };
        });
    } else {
        sendingComment.value[postId] = false;
        comments.value[postId] = {
            loading: false,
            comments: []
        };
    }
}
async function fetchPosts() {
    loadingPosts.value = true;
    let data = await fetch(getAPIPath(true) + "/posts/")
    loadingPosts.value = false;
    posts.value = await data.json();
    await fetchComments();
}
async function fetchComments(postId) {
    resetComments(postId);
    setCommentsLoading(postId, true);
    let url = getAPIPath(true);
    if (postId === undefined) {
        url += "/comments/";
    } else {
        url += "/post/comments/" + postId
    }
    let data = await fetch(url);
    if (!data.ok) {
        return;
    }
    setCommentsLoading(postId, false);
    data = await data.json();
    data.forEach(comment => {
        comments.value[comment.parent].comments.push(comment);
    });
}

async function sendComment(postId) {
    const commentText = commentTextareas[postId];
    await send(postId, commentText);
    await fetchComments(postId);
}

async function send(postId, text) {
    const form = new FormData();
    form.append("post", text);
    form.append("parent", postId);
    form.append("user", usePage().props.auth.user.id);
    sendingComment.value[postId] = true;
    let data = await fetch(getAPIPath(true) + `/comments/`, {
        method: "POST",
        body: form
    });
    if (!data.ok) {
        return;
    }
    sendingComment.value[postId] = false;
}
</script>

<template>
    <v-skeleton-loader v-if="loadingPosts" type="card"></v-skeleton-loader>
    <div v-else class="flex gap-y-3 flex-wrap">
        <v-card
            v-for="item in posts"
            :key="item.id"
            class="w-full"
        >
            <template v-slot:subtitle>
                <PostHeader
                    :first_name="item.first_name"
                    :last_name="item.last_name"
                    :created_at="item.created_at"
                    :user="item.user"
                    :id="item.id"
                    type="posts"
                />
            </template>
            <v-card-text>
                <PostText type="posts" :text="item.post"></PostText>
                <v-textarea
                    v-model="commentTextareas[item.id]"
                    @click:append="sendComment(item.id)"
                    append-icon="mdi-send-outline"
                    auto-grow
                    rows="1"
                    no-resize
                    :loading="sendingComment[item.id]"
                    :disabled="sendingComment[item.id]"
                    class="p-2"
                    label="Comment..."
                ></v-textarea>
                <Comment :comment="comments[item.id]"></Comment>
            </v-card-text>
        </v-card>
    </div>
</template>
