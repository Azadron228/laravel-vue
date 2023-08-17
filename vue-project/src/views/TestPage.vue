<template>
  <div>
    <!-- Your content here -->
    <Pagination
      :currentPage="currentPage"
      :totalPages="totalPages"
      :onPageChange="changePage"
    />
  </div>
</template>

<script>
import Pagination from "../components/Pagination.vue";

export default {
  components: {
    Pagination
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 30 // Set your total number of pages here
    };
  },
  methods: {
    changePage(pageNumber) {
      this.currentPage = pageNumber;
      // Fetch or update data based on the new page number
    }
  }
};
</script>
