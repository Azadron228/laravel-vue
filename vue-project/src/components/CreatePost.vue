<template>
  <div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Create a New Post</h2>
    <form @submit.prevent="submitPost">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input v-model="post.title" type="text" class="mt-1 p-2 w-full border rounded-md" required />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Content</label>
        <textarea v-model="post.content" class="mt-1 p-2 w-full border rounded-md" rows="4" required></textarea>
      </div>
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Post</button>
    </form>
  </div>
</template>

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      post: {
        title: '',
        content: '',
      },
    };
  },
  methods: {
    async submitPost() {
      try {
        const response = await axios.post('post/create', this.post); // Replace with your API endpoint
        console.log('Post created:', response.data);
        // Optionally, you can emit an event to notify a parent component that a post was created.
        // this.$emit('postCreated', response.data);
        this.clearForm();
      } catch (error) {
        console.error('Error creating post:', error);
      }
    },
    clearForm() {
      this.post.title = '';
      this.post.content = '';
    },
  },
};
</script>

<style scoped>
/* Add Tailwind CSS classes or custom styles here */
</style>
