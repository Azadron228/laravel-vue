<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="my-4 rounded outline outline-offset-2 outline-gray-200">
      <h2 class="text-lg font-semibold">{{ post.title }}</h2>
      <p class="text-gray-700">{{ post.content}}</p>
    </div>

    <Pagination
      :currentPage="currentPage"
      :totalPages="totalPages"
      :onPageChange="changePage"
    />
  </div>
</template>

<script>
import axios from '../api.js';
import Pagination from "@/components/Pagination.vue";

export default {
  components: {
    Pagination
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 1,
      posts: []
    };
  },
  async created() {
    await this.fetchPosts();
  },
  watch: {
    '$route.query.page'(newPage) {
      this.currentPage = newPage ? parseInt(newPage) : 1;
      this.fetchPosts();
    }
  },
  methods: {
    async fetchPosts() {
      try {
        const response = await axios.get(`/posts`, {
          params: {
            page: this.currentPage,
          }
        });
        this.posts = response.data.data;

        // Assuming you know the total number of posts available from the API
        this.totalPages = response.data.totalPages;
      } catch (error) {
        console.error("Error fetching posts:", error);
      }
    },
    changePage(pageNumber) {
      this.currentPage = pageNumber;
      this.$router.push({ query: { page: pageNumber } });
      this.fetchPosts();
    }
  }
};
</script>
