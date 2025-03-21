<template>
  <button
      :type="type"
      class="rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:ring active:bg-purple-600"
      :class="classBtn"
      :v-show="show"
  >
    <slot/>
  </button>
</template>

<script setup>

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    classBtn: {
        type: String,
        default: '',
    },
    show: {
        type: Boolean,
        default: true,
    },
});

</script>

<!--<template>-->
<!--    <div>-->
<!--        <button-->
<!--            :type="type"-->
<!--            :class="classBtn"-->
<!--            v-show="show"-->
<!--        >-->
<!--            <slot/>-->
<!--        </button>-->
<!--    </div>-->
<!--</template>-->

<!--<script setup>-->
<!--defineProps({-->
<!--    type: {-->
<!--        type: String,-->
<!--        default: 'submit',-->
<!--    },-->
    classBtn: {
        type: String,
        default: '',
    },
<!--    show: {-->
<!--        type: Boolean,-->
<!--        default: true,-->
<!--    },-->

<!--});-->
<!--</script>-->
