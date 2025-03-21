<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
const roles = ref([]);
const roles_string = ref(" ");

import { is, can } from 'laravel-permission-to-vuejs'

if(is('super-admin')){
    // do admin actions
}

if(can('edit post')){
    // do edit post action
}


</script>

<template>
	<Head title="Dashboard" />

	<AuthenticatedLayout>
		<template #header>
			Dashboard
		</template>
        <div class="p-4 bg-white rounded-lg shadow-xs">
            Bienvenido <strong class="text-green-800 uppercase">{{ $page.props.auth.user.full_name }} {{ roles_string }}</strong>!
        </div>

		<div class="p-4 bg-white rounded-lg shadow-xs">
			You're logged in!
		</div>
	</AuthenticatedLayout>
</template>
