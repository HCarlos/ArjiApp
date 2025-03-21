<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-red-950 border border-red-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

