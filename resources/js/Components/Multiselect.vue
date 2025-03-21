<template>
    <label class="block mt-4 text-sm h-96">
        <span class="text-white-700 dark:text-white-400">{{labelText}}</span>
        <select
            class="block w-full mt-1 text-sm dark:text-white-300 dark:border-white-600 dark:bg-white-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-white"
            multiple
            ref="selected"
            :class="classEspecial"

        >
            <option v-for="(item, index) in opciones" :key="index" :value="item.id" >
                {{ item.text }}
            </option>
        </select>
    </label>
</template>

<script setup>

import { onMounted, ref } from 'vue';

const props = defineProps({
    textLabel: {
        type: String,
        default: ''
    },
    opciones: {
        type: Object
    },
    classEspecial: {
        type: String,
        default: ''
    },
    selected: {
        type: Array,
        default: []
    },
    modelValue: {
        type: Object
    }
});

// defineEmits(['update:modelValue']);
defineEmits(['update:modelValue','selected']);

const selected = ref(null);

onMounted(() => {
    selected.value = props.selected;
});

</script>
