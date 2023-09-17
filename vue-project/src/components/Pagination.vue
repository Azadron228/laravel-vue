<template>
  <ul v-if="last_page > 1" class="pagination flex space-x-2">
    <li
      v-for="item in last_page"
      :key="item"
      class="page-item"
      :class="{ 'bg-blue-500 text-white': item === current_page }"
    >
      <router-link
        to=""
        class="page-link block py-2 px-3 rounded-full hover:bg-blue-300"
        @click="$emit('currentChange', item)"
      >
        {{ item }}
      </router-link>
    </li>
  </ul>
</template>


<script setup>
import { toRefs, defineEmits } from 'vue';

const {current_page, last_page } = defineProps({
  current_page: Number,
  last_page: Number,
});
defineEmits(['currentChange']);

</script>
