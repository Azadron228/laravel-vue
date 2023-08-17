<template>
  <div class="max-w-md mx-auto mt-4 p-4">
    <h2 class="text-xl font-semibold mb-2">{{ post.title }}</h2>
    <p class="text-gray-600">{{ post.content }}</p>
  </div>
</template>

<script>
import axios from '@/api.js';

export default {
  data() {
    return {
      post: {},
    };
  },
  created() {
    const postId = this.$route.params.id; // Fetch the ID parameter from the route
    axios.get(`/post/${postId}`) // Replace with your API endpoint
      .then(response => {
        this.post = response.data;
      })
      .catch(error => {
        console.error('Error fetching post:', error);
      });
  },
};
</script>

<style scoped>
/* Tailwind CSS classes can be applied here */
</style>
