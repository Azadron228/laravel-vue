<template>
  <div aria-label="Pagination" class="flex items-center justify-between py-4">
    <p class="text-sm text-gray-500">
      Page {{ meta.current_page }} of {{ meta.last_page }}
    </p>
    <div class="flex">
      <button
        rel="first"
        type="button"
        @click="firstPage"
        v-if="links.prev"
        class="px-4 py-2 m-1 text-sm text-pink-400 border rounded hover:text-pink-500"
      >
        First
      </button>

      <button
        rel="prev"
        type="button"
        @click="prevPage"
        :class="{ 'rounded-r': !links.next }"
        v-if="links.prev"
        class="px-4 py-2 m-1 text-sm text-pink-400 border rounded hover:text-pink-500"
      >
        Previous
      </button>

      <button
        rel="next"
        type="button"
        @click="nextPage"
        :class="{ 'rounded-l': !links.prev }"
        v-if="links.next"
        class="px-4 py-2 m-1 text-sm text-pink-400 border rounded hover:text-pink-500"
      >
        Next
      </button>

      <button
        rel="last"
        type="button"
        @click="lastPage"
        v-if="links.next"
        class="px-4 py-2 m-1 text-sm text-pink-400 border rounded hover:text-pink-500"
      >
        Last
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  action: {
    type: String,
    required: true,
  },
  path: {
    type: String,
    default: null,
  },
  meta: {
    type: Object,
    required: true,
  },
  links: {
    type: Object,
    required: true,
  },
});

const firstPage = () => {
  store.dispatch(props.action, props.links.first).then(() => {
    if (props.path) {
      router.push({
        path: props.path,
        query: { page: 1 },
      });
    }
  });
};

const prevPage = () => {
  store.dispatch(props.action, props.links.prev).then(() => {
    if (props.path) {
      router.push({
        path: props.path,
        query: { page: props.meta.current_page - 1 },
      });
    }
  });
};

const nextPage = () => {
  store.dispatch(props.action, props.links.next).then(() => {
    if (props.path) {
      router.push({
        path: props.path,
        query: { page: props.meta.current_page + 1 },
      });
    }
  });
};

const lastPage = () => {
  store.dispatch(props.action, props.links.last).then(() => {
    if (props.path) {
      router.push({
        path: props.path,
        query: { page: props.meta.last_page },
      });
    }
  });
};
</script>
