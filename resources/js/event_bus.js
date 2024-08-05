// src/eventBus.js
import { ref } from 'vue';

const eventBus = ref({
    on(event, callback) {
        this[event] = callback;
    },
    emit(event, data) {
        if (this[event]) {
            this[event](data);
        }
    }
});

export default eventBus;
