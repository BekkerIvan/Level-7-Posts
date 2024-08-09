<script setup>
import PostEdit from "@/posts/PostEdit.vue";

const props = defineProps(["text"]);
</script>

<template>
{{ text }}
<PostEdit></PostEdit>
</template>
