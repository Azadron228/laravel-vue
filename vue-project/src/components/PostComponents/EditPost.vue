<template>
  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Edit Post</h2>
    
    <div class="mb-4">
      <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
      <input v-model="editedTitle" type="text" id="title" name="title" class="mt-1 p-2 w-full border rounded-md">
    </div>
    
    <div class="mb-4">
      <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
      <textarea v-model="editedContent" id="content" name="content" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
    </div>
    
    <button @click="updatePost" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Update Post</button>
  </div>
</template>

<script>
import axios from '@/api.js';

export default {
  data() {
    return {
      postId: null,
      editedTitle: '',
      editedContent: ''
    };
  },
  async created() {
    // Fetch the post data using API
    try {
      const postId = this.$route.params.id; // Assuming you're using Vue Router to get the postId from the route
      const response = await axios.get(`/post/${postId}`);
      
      this.postId = response.data.id;
      this.editedTitle = response.data.title;
      this.editedContent = response.data.content;
    } catch (error) {
      console.error('Error fetching post data:', error);
    }
  },
  methods: {
    async updatePost() {
      try {
        const requestData = new FormData();
        requestData.append('title', this.editedTitle);
        requestData.append('content', this.editedContent);

        await axios.put(`/post/${this.postId}`, requestData);

        // Redirect to the post details page or perform other actions
      } catch (error) {
        console.error('Error updating post:', error);
      }
    }
  }
};
</script>

<style>
/* You can add custom styling here if needed */
</style>
