
<template>
    <div class="flex items-center justify-between p-2 pl-4 pr-4 mb-2 text-sm font-semibold text-gray-600 bg-orange-200 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
         href="{{ HRefViewMore }}"
         :class="classMsg"
    >
    <div class="flex items-center">
        <span :class="classIcon"><slot  /></span>
        <span class="ml-2 text-gray-800 font-bold">{{ Msg }}</span>
    </div>
    <span>{{ ViewMore }}</span>
    </div>
</template>

<script setup>

const props = defineProps(['classMsg','Msg','ViewMore','HRefViewMore','classIcon']);

</script>
