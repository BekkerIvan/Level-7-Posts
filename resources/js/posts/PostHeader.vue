<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {getAPIPath} from "@/assets.js";
import eventBus from "@/event_bus.js";

const props = defineProps({
    id: Number,
    parent: Number,
    first_name: String,
    last_name: String,
    created_at: String,
    type: String,
    user: Number
});
const isDeleting = ref(false);
const items = [
    {
        icon: "mdi-delete-empty",
        text: "Delete",
        fn: async (id, parent) => {
            isDeleting.value = true;
            const request = await fetch(getAPIPath(true) + `/${props.type}/${id}`, {
                method: "DELETE"
            });

            if (!request.ok) {
                return;
            }
            isDeleting.value = false;
            const data = {};
            data[props.type]["id"] = id;
            data[props.type]["parent"] = parent;
            eventBus.value.emit('refresh', data);
        }
    },
    {
        icon: "mdi-file-edit",
        text: "Edit",
        fn: async (id) => {
            eventBus.value.emit('editing', id);
        }
    },
];
const currentUser = usePage().props.auth.user.id;
const showMenu = currentUser === props.user;
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-x-2">
            <v-chip >
                {{ first_name }} {{ last_name }}
            </v-chip>
            <small class="float-end">{{ created_at }}</small>
        </div>
        <div class=" text-right">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn :disabled="isDeleting" v-if="showMenu" size="x-small" class="mr-1" icon="mdi-dots-vertical" v-bind="props"></v-btn>
                </template>
                <v-list>
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        @click="item.fn(id, parent)"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="item.icon"></v-icon>
                        </template>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>
    </div>
</template>
