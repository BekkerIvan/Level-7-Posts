<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PostDashboard from "@/posts/PostDashboard.vue";
import AddPost from "@/posts/AddPost.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="w-full px-5 py-2">
            <v-row no-gutters class="flex-column-reverse flex-md-row">
                <v-col cols="12" md="3"></v-col>
                <v-col cols="12" md="6">
                    <PostDashboard/>
                </v-col>
                <v-col cols="12" md="3">
                    <AddPost/>
                </v-col>
            </v-row>
        </div>
    </AuthenticatedLayout>
</template>
