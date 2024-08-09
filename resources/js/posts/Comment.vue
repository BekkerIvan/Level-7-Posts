<script setup>

import PostHeader from "@/posts/PostHeader.vue";
import PostText from "@/posts/PostText.vue";
const props = defineProps(["comment"]);
</script>

<template>
    <v-skeleton-loader v-if="comment.loading" type="paragraph"></v-skeleton-loader>
    <v-expansion-panels v-else-if="comment.comments.length > 0">
        <v-expansion-panel
            title="Comments"
        >
            <template v-slot:text>
                <div class="my-3" v-for="(comment, index) in comment.comments">
                    <PostHeader
                        :first_name="comment.first_name"
                        :last_name="comment.last_name"
                        :created_at="comment.created_at"
                        :user="comment.user"
                        :id="comment.id"
                        :parent="comment.parent"
                        type="comments"
                    />
                    <v-card class="mt-2">
                        <template v-slot:text>
                            <PostText :text="comment.post"></PostText>
                        </template>
                    </v-card>
                </div>
            </template>
        </v-expansion-panel>
    </v-expansion-panels>
</template>
