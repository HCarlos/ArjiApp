<template>
    <div>
        <h1 class="text-xl font-bold mb-4">Asignación Masiva de Roles</h1>
        <form @submit.prevent>
            <!-- Selección de Usuarios -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Usuarios</h2>
                <div v-for="user in users" :key="user.id" class="flex items-center my-1">
                    <input
                        type="checkbox"
                        :value="user.id"
                        v-model="form.user_ids"
                        class="mr-2"
                    />
                    <span>{{ user.name }}</span>
                </div>
            </div>
            <!-- Selección de Roles -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Roles</h2>
                <div v-for="role in roles" :key="role.id" class="flex items-center my-1">
                    <input
                        type="checkbox"
                        :value="role.id"
                        v-model="form.role_ids"
                        class="mr-2"
                    />
                    <span>{{ role.name }}</span>
                </div>
            </div>
            <!-- Botones de acción -->
            <div class="flex gap-4">
                <button type="button" @click="handleSubmit('assign')" class="px-4 py-2 bg-green-500 text-white rounded">
                    Asignar Roles
                </button>
                <button type="button" @click="handleSubmit('remove')" class="px-4 py-2 bg-red-500 text-white rounded">
                    Quitar Roles
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
    users: Array,
    roles: Array,
})

// Inicializamos el formulario con arrays vacíos para los IDs de usuarios y roles
const form = useForm({
    user_ids: [],
    role_ids: [],
})

function handleSubmit(action) {
    let url = '';
    if (action === 'assign') {
        url = route('bulk.roles.assign');
    } else if (action === 'remove') {
        url = route('bulk.roles.remove');
    }
    form.post(url);
}
</script>

<style scoped>
/* Puedes agregar estilos personalizados según tus necesidades */
</style>
