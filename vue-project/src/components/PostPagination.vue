<template>
  <div class="flex flex-col items-center">
    <div class="mt-5">
      <button
        @click="fetchPosts(currentPage - 1)"
        :disabled="currentPage === 1"
        class="px-3 py-2 bg-blue-500 text-white rounded-lg"
      >
        Previous
      </button>
      <button
        @click="fetchPosts(currentPage + 1)"
        :disabled="currentPage === totalPages"
        class="ml-3 px-3 py-2 bg-blue-500 text-white rounded-lg"
      >
        Next
      </button>
    </div>
    <div class="mt-5">
      <ul>
        <li v-for="post in posts" :key="post.id" class="mb-3">
          {{ post.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      currentPage: 1,
      totalPages: 0,
      posts: []
    };
  },
  mounted() {
    this.fetchPosts(this.currentPage);
  },
  methods: {
    fetchPosts(page) {
      axios.get(`/posts?page=${page}`).then(response => {
        this.posts = response.data.data;
        this.currentPage = response.data.current_page;
        this.totalPages = response.data.total_pages;
      });
    }
  }
};
</script>

<style scoped>
/* Add your Tailwind CSS styles here */
</style>
