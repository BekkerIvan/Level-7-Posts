<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PostDashboard from "@/posts/PostDashboard.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <v-container>
            <v-row no-gutters>
                <v-col cols="12" sm="8" offset-sm="2" md="6" offset-md="3">
                    <PostDashboard/>
                </v-col>
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
