<template>
    <label class="block text-sm ">
        <span class="text-gray-700 dark:text-gray-400">{{labelText}}</span>
        <div class="relative text-gray-500 focus-within:text-gray-700 gray:focus-within:text-gray-700 ">
            <input
                class="block w-full pl-10 mt-1 text-sm cols-1 text-dark text-dark-100 border-gray-700 bg-gray-50 focus:border-gray-700 focus:outline-none focus:shadow-outline-gray gray:focus:shadow-outline-gray form-input rounded-md "
                :value="modelValue"
                :type="type"
                :required="required"
                :placeholder="placeholder"
                :accept="accept"
                :disabled=disabledInput
                :pattern="pattern"
                @input="$emit('update:modelValue', $event.target.value)"
                @change="$emit('change', $event)"
                ref="input"
                :class="classEspecial"
                :name="nameObject"
                :id="nameObject"
                :src="src"
            />
            <div class="absolute inset-y-0 flex items-center ml-2 pointer-events-none">
                <slot />
            </div>
        </div>
    </label>
    <small class="text-muted text-xs text-gray-400">{{mensajeMiniatura}}</small>
    <InputError class="mt-1" :message="errors" />
</template>

<script setup>

import { onMounted, ref } from 'vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps(
    ['textLabel','text','placeholder','accept','required','type','modelValue',
        'change','errors','disabledInput','pattern','classEspecial',
        'mensajeMiniatura','nameObject','src'
    ]);
defineEmits(['update:modelValue','change']);



const labelText = props.textLabel == null ? '' : props.textLabel;
const disabledInput = props.disabledInput != null;

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }




});

</script>
