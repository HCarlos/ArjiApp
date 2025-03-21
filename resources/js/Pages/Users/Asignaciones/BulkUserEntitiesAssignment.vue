<script setup>
// --- IMPORTS ---
import { ref, computed, reactive } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import "/resources/css/User/asignaciones_v1.css";

// --- PROPS ---
const props = defineProps({
    users: Array,               // Lista de usuarios desde backend
    allDatas: Array,            // Todos los elementos disponibles (roles/datos)
    assignedDatasByUser: Object,// Mapa de asignaciones {user_id: [...]}
    tableName: String,          // Nombre de la entidad (ej: "Roles")
    addUrl: String,             // Endpoint para agregar
    removeUrl: String,          // Endpoint para remover
});

// --- REACTIVE STATE ---
const selectedUserId = ref(null);           // ID del usuario seleccionado
const selectedAvailable = ref([]);          // IDs de elementos seleccionados en disponibles
const selectedAssigned = ref([]);           // IDs de elementos seleccionados en asignados
const localAssignedDatas = reactive({       // Copia reactiva de las asignaciones
    ...props.assignedDatasByUser            // Inicializado con datos del backend
});

// --- COMPUTED PROPERTIES ---
const assignedDatas = computed(() => {
    // Obtiene elementos asignados al usuario seleccionado
    return selectedUserId.value
        ? localAssignedDatas[selectedUserId.value] || []
        : [];
});

const availableDatas = computed(() => {
    // Filtra elementos no asignados
    const assignedIds = assignedDatas.value.map(d => d.id);
    return props.allDatas.filter(d => !assignedIds.includes(d.id));
});

// --- METHODS ---
const addDatas = async () => {
    try {
        // Envía IDs seleccionados al endpoint de agregar
        const response = await axios.post(props.addUrl, {
            user_id: selectedUserId.value,  // ID del usuario objetivo
            datas: selectedAvailable.value  // IDs a asignar
        });

        // Actualiza estado local con respuesta del servidor
        localAssignedDatas[selectedUserId.value] =
            response.data.data[selectedUserId.value];

        selectedAvailable.value = [];  // Limpia selección
    } catch (error) {
        // Manejo de errores con mensaje del servidor o genérico
        alert('Error al asignar: ' + error.response?.data?.message || error.message);
    }
};

const removeDatas = async () => {
    try {
        // Envía IDs seleccionados al endpoint de remover
        const response = await axios.post(props.removeUrl, {
            user_id: selectedUserId.value,  // ID del usuario objetivo
            datas: selectedAssigned.value   // IDs a remover
        });

        // Actualiza estado local con respuesta del servidor
        localAssignedDatas[selectedUserId.value] =
            response.data.data[selectedUserId.value];

        selectedAssigned.value = [];  // Limpia selección
    } catch (error) {
        // Manejo de errores con mensaje del servidor o genérico
        alert('Error al remover: ' + error.response?.data?.message || error.message);
    }
};
</script>

<template>
    <Head :title="`Asignación de ${tableName}`" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl font-bold text-gray-800">
                Asignación de {{ tableName }}
            </h1>
        </template>

        <div class="container">
            <!-- Selector de usuario nativo mejorado -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Seleccionar usuario:
                </label>
                <select
                    v-model="selectedUserId"
                    class="select-style"
                >
                    <option :value="null">-- Seleccione un usuario --</option>
                    <option
                        v-for="user in users"
                        :key="user.id"
                        :value="user.id"
                    >
                        {{ user.username }} (ID: {{ user.id }})
                    </option>
                </select>
            </div>

            <div v-if="selectedUserId" class="flex gap-6 items-stretch">
                <!-- Panel disponibles -->
                <div class="panel">
                    <div class="panel-header">
                        <h3 class="text-lg font-semibold">{{ tableName }} disponibles ({{ availableDatas.length }})</h3>
                    </div>
                    <div class="list-container">
                        <div
                            v-for="item in availableDatas"
                            :key="item.id"
                            class="list-item"
                        >
                            <label class="flex items-center w-full cursor-pointer space-x-3">
                                <input
                                    type="checkbox"
                                    :value="item.id"
                                    v-model="selectedAvailable"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300"
                                >
                                <span class="text-gray-700">{{ item.data }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="transfer-buttons">
                    <button
                        @click="addDatas"
                        :disabled="!selectedAvailable.length"
                        class="btn-action bg-emerald-600 hover:bg-emerald-700 text-white"
                    >
                        Agregar →
                    </button>
                    <button
                        @click="removeDatas"
                        :disabled="!selectedAssigned.length"
                        class="btn-action bg-rose-600 hover:bg-rose-700 text-white"
                    >
                        ← Quitar
                    </button>
                </div>

                <!-- Panel asignados -->
                <div class="panel">
                    <div class="panel-header">
                        <h3 class="text-lg font-semibold">{{ tableName }} asignados ({{ assignedDatas.length }})</h3>
                    </div>
                    <div class="list-container">
                        <div
                            v-for="item in assignedDatas"
                            :key="item.id"
                            class="list-item"
                        >
                            <label class="flex items-center w-full cursor-pointer space-x-3">
                                <input
                                    type="checkbox"
                                    :value="item.id"
                                    v-model="selectedAssigned"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300"
                                >
                                <span class="text-gray-700">{{ item.name }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
