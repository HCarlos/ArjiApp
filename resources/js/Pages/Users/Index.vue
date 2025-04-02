<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import {destroyDataTable, initializeDataTable} from "@/js/arjiapp";
import $ from 'jquery';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import DataTable from 'datatables.net-dt';
import {onBeforeUnmount, onMounted, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UserModal from "@/Components/Users/UserModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
// import { initFlowbite } from 'flowbite'

import {router} from "@inertiajs/vue3";
import "/resources/css/general.css";

const props = defineProps({
	users: {
		type: Object
	},
    totalAlumnos: Number   // Total de alumnos
})

const selectedUserId = ref(0);           // ID del usuario seleccionado

const textSearch = ref('');
const showCreateModal = ref(false);

// Referencia para la instancia de DataTable
const dataTable = ref(null);

const handleClose = () => {
    console.log('Evento close recibido') // Para depuración
    selectedUserId.value = null
}
// Inicializar DataTable después de montar
onMounted(() => {
    initializeDataTable(dataTable);
    // initFlowbite();
});

// Destruir antes de desmontar
onBeforeUnmount(() => {
    destroyDataTable();
});

// Reiniciar al actualizar datos
watch(() => props.users, () => {
    destroyDataTable();
    initializeDataTable();
});


const destroy = (userId) => {
    if (confirm('¿Estás seguro de que deseas eliminar el usuario '+userId+' ?')) {

        const url = route('users.delete', userId)

        const method = 'delete'

        router[method](url, {
            preserveScroll: true,
            onSuccess: () => {
                alert('Usuario '+userId+' eliminado correctamente');
                $("#tblUser-"+userId).remove();
            },
            onError: (err) => {
                errors.value = err
            },
            onFinish: () => {
                $("#tblUser-"+userId).remove();
            }
        })

    }
}

</script>

<style>
/* Personalización adicional */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    @apply px-3 py-3 mx-1 rounded border bg-white hover:bg-gray-100 transition-colors;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    @apply bg-blue-500 text-white border-blue-500 hover:bg-blue-600;
}
</style>

<template>

    <!-- Modal de creación -->
    <UserModal
        v-if="showCreateModal"
        mode="create"
        class="z-10"
        @close="showCreateModal = false"
    />
    <!-- Modal de edición -->
    <UserModal
        v-if="selectedUserId"
        :user="{...selectedUserId}"
        mode="edit"
        class="z-21"
        @close="handleClose"
    />

    <AuthenticatedLayout>
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
				<div class="flex justify-center items-center w-12 bg-blue-500">
					<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white ">
                        <path d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
				</div>

				<div class="px-4 py-2 -mx-3 w-full">
					<span class="mx-3 float-start">
						<span class="font-semibold text-blue-500">({{ totalAlumnos }}) Usuarios</span>
						<p class="text-sm text-gray-600">Catálago general</p>
<!--                         <p>Valor actual: {{ textSearch.length }}</p>-->

					</span>

                    <SecondaryButton @click="() => showCreateModal = true" class="mt-1" data-tooltip-target="tooltip-default"><strong><i class="fa fa-user-plus font-extrabold text-2xl text-purple-700 mr-2"></i></strong>Crear Usuario</SecondaryButton>

                    <span
                        class=" float-end px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9">
                        <form action="/users">
                        <input
                            type="text"
                            name="search"
                            v-model="textSearch"
                            id="search"
                            placeholder="Buscar...">
                        <primary-button :class-btn="'float-end ml-2'" :show="textSearch.length === 0" :disabled="textSearch.length === 0" :type="'submit'" >Buscar</primary-button>
                        </form>
                    </span>
                    <span
                        class=" float-end px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9">
                        <pagination :links="users.links" />
                    </span>

                </div>
			</div>

			<div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
				<div class="overflow-x-auto w-full">
					<table id="datasTable" class="w-full whitespace-no-wrap">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
								<th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Username</th>
                                <th class="px-4 py-3">Nombre Completo</th>
								<th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">CURP</th>
                                <th class="px-4 py-3"></th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y">
							<tr v-for="user in users.data" :key="user.id" class="text-gray-700 delete-button"  :id="'tblUser-' + user.id" >
                                <td class="px-4 py-3 text-sm">{{ user.id }}</td>
								<td class="px-4 py-3 text-sm">{{ user.username }}</td>
                                <td class="px-4 py-3 text-sm">{{ user.full_name }}</td>
								<td class="px-4 py-3 text-sm">{{ user.email }}</td>
                                <td class="px-4 py-3 text-sm">{{ user.curp }}</td>
                                <td class="px-4 py-3 text-sm td-buttons">
                                    <SecondaryButton as="button" @click="destroy(user.id)" class="icon-button-trash"><i class="fa fa-trash"></i></SecondaryButton>
                                    <SecondaryButton as="button" @click="() => { selectedUserId = user }"  class="icon-button-edit"><i class="fa fa-edit"></i></SecondaryButton>
                                </td>

                            </tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
