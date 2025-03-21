<template>
    <label class="block text-sm ">
        <span class="text-gray-700 dark:text-gray-400">{{labelText}}</span>
        <div class="relative text-gray-500 focus-within:text-gray-700 gray:focus-within:text-gray-700 ">
            <select
                class="block w-full pl-10 mt-1 text-sm cols-1 text-dark text-dark-100 border-gray-700 bg-gray-50 focus:border-gray-700 focus:outline-none focus:shadow-outline-gray gray:focus:shadow-outline-gray form-input rounded-md "
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @change="$emit('change', $event)"
                ref="select"
                :class="classEspecial"
            >
<!--                <option value="-1" :selected="selected">Selecciona una opción</option>-->
                <option value="-1" selected>Selecciona una opción</option>
                <option v-for="(item, index) in opciones" :key="index" :value="item.id" >
                    {{ item.text }}
                </option>
            </select>
            <div class="absolute inset-y-0 flex items-center ml-2 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 0 0 0-5.25H5.625ZM3.75 11.25a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75ZM3 15.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75ZM3.75 18.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" />
                </svg>
            </div>
        </div>
    </label>
    <InputError class="mt-1" :message="errors" />
</template>

<script setup>

import { onMounted, ref } from 'vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps(
    ['textLabel','opciones','modelValue','isLegend','errors','classEspecial','change']
);


const labelText = props.textLabel == null ? '' : props.textLabel;
// const disabledSelect = props.disabledSelect != null;
const isLegend = props.isLegend != null;

// defineEmits(['update:modelValue']);
defineEmits(['update:modelValue','change']);

const select = ref(null);
onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
    if (!isLegend) {
        select.selected = true;
    }
});


</script>
