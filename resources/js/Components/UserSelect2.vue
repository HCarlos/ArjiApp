<template>
    <select
        v-model="selectedUserId"
        ref="userSelect"
        class="select-style">
        <option :value="null">-- Seleccione un usuario --</option>
        <option
            v-for="user in users"
            :key="user.id"
            :value="user.id"
        >
            {{ user.full_name }} - {{ user.username }}
        </option>
    </select>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css'; // Importa los estilos de Select2

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    initialSelectedUserId: {
        type: Number,
        default: null,
    },
});

const selectedUserId = ref(props.initialSelectedUserId);
const userSelect = ref(null);

onMounted(() => {
    $(userSelect.value)
        .select2()
        .on('change', () => {
            selectedUserId.value = $(userSelect.value).val();
        });
});

watch(selectedUserId, (newVal) => {
    $(userSelect.value).val(newVal).trigger('change.select2');
});

// Asegura que el valor inicial se establezca
onMounted(() => {
    if (selectedUserId.value) {
        $(userSelect.value).val(selectedUserId.value).trigger('change.select2');
    }
});
</script>

<style scoped>
/* Estilos adicionales si es necesario */
.select-style {
    width: 100%; /* Ajusta el ancho según tus necesidades */
}
</style>
