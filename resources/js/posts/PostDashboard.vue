<script setup>
import { ref } from 'vue'
import {getAPIPath} from "@/assets.js";

const loading = ref(true);
let posts = [];

(async () => {
    loading.value = true;
    await fetch(getAPIPath(true)+"/posts").then((response) => {
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

</script>

<template>
    <v-skeleton-loader v-if="loading" type="card"></v-skeleton-loader>
    <div v-else class="flex gap-y-3 flex-wrap">
        <v-card
            v-for="item in posts"
            class="mx-auto"
            :hover
        >
            <template v-slot:subtitle class="flex">
                <v-btn size="small" variant="plain">{{ item.first_name }} {{ item.last_name }}</v-btn>
                <small>{{ item.created_at }}</small>
            </template>
            <v-card-text>
                {{ item.post }}
            </v-card-text>
        </v-card>
    </div>
</template>
