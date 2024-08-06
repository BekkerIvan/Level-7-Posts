<script setup>
defineProps(["first_name", "last_name", "created_at", "show_delete"]);

const items = [
    {
        icon: "mdi-delete-empty",
    },
    {
        icon: "mdi-file-edit"
    },
];
</script>

<template>
    <div class="flex justify-between items-center">
        <div class="flex flex-column items-start">
            <v-chip class="ma-2 " label>
                {{ first_name }} {{ last_name }}
            </v-chip>
            <small class="float-end">{{ created_at }}</small>
        </div>
        <div class="w-full text-right">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                </template>

                <v-list>
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                    >
                        <v-list-item-title>
                            <v-icon :icon="item.icon"></v-icon>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>
    </div>
</template>
