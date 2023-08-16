<template>
  <div class="flex flex-col items-center mt-5">
    <h1 class="text-2xl font-bold mb-3">List of Posts</h1>
    <ul class="grid grid-cols-2 gap-4">
      <li v-for="post in posts" :key="post.id" class="bg-white p-4 shadow-md rounded-md">
        <h2 class="text-lg font-semibold">{{ post.title }}</h2>
        <p class="text-gray-600">{{ post.content }}</p>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      posts: []
    };
  },
  mounted() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      try {
        const response = await axios.get('/posts');
        this.posts = response.data.data;
        console.log(response.data);
      } catch (error) {
        console.error('Error fetching posts:', error);
      }
    }
  }
};
</script>

<style scoped>
/* Add Tailwind classes or custom styles here */
</style>
