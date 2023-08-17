<template>
  <nav class="flex items-center justify-center mt-4">
    <ul class="flex space-x-2">
      <li>
        <button
          @click="goToPage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-2 py-1 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
          Previous
        </button>
      </li>
      <li>
        <button
          v-for="pageNumber in displayedPages"
          :key="pageNumber"
          @click="goToPage(pageNumber)"
          :class="{
            'px-3 py-1 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none': true,
            'bg-gray-200': pageNumber === currentPage
          }"
        >
          {{ pageNumber }}
        </button>
      </li>
      <li>
        <button
          @click="goToPage(currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="px-2 py-1 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
          Next
        </button>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    currentPage: Number,
    totalPages: Number,
    onPageChange: Function,
    maxDisplayedPages: {
      type: Number,
      default: 7
    }
  },
  computed: {
    displayedPages() {
      const startPage = Math.max(1, this.currentPage - Math.floor(this.maxDisplayedPages / 2));
      const endPage = Math.min(this.totalPages, startPage + this.maxDisplayedPages - 1);

      const pages = [];
      for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
      }

      return pages;
    }
  },
  methods: {
    goToPage(pageNumber) {
      if (pageNumber >= 1 && pageNumber <= this.totalPages) {
        this.onPageChange(pageNumber);

        this.$router.push({ query: { page: pageNumber } });
      }
    }
  }
};
</script>
