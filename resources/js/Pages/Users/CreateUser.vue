<template>
    <!-- Botón para abrir modal -->
    <button @click="showCreateModal = true">Crear Usuario</button>

    <!-- Modal de creación -->
    <UserModal
        v-if="showCreateModal"
        mode="create"
        @close="showCreateModal = false"
    />

    <!-- Modal de edición -->
<!--    <UserModal-->
<!--        v-if="selectedUser"-->
<!--        :user="selectedUser"-->
<!--        mode="edit"-->
<!--        @close="selectedUser = null"-->
<!--    />-->
</template>
<script setup lang="ts">
import UserModal from "@/Components/Users/UserModal.vue";
</script>
