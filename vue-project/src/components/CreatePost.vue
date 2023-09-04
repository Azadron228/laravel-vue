<template>
  <div class="max-w-3xl mx-auto mt-6 p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold">Create a New Post</h1>
    <form @submit.prevent="createPost">
      <div class="mb-4">
        <label for="title" class="block font-semibold">Title</label>
        <input v-model="post.title" type="text" id="title" class="w-full px-3 py-2 border rounded">
      </div>
      <div class="mb-4">
        <label for="body" class="block font-semibold">Body</label>
        <textarea v-model="post.body" id="body" class="w-full px-3 py-2 border rounded" rows="4"></textarea>
      </div>
      <div class="mb-4">
        <label for="thumbnail" class="block font-semibold">Thumbnail</label>
        <input type="file" ref="fileInput" id="thumbnail" @change="handleThumbnailUpload">
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Post</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import api from '../api/index.ts'

const post = ref({
  title: '',
  body: '',
  thumbnail: '',
});

const handleThumbnailUpload = (e) => {
  const file = e.target.files[0];
  post.value.thumbnail = file;
  console.log(post.value);
};

const createPost = async () => {
  try {
    const response = await api.createPost(post.value);
    console.log('Post created:', response.data);
    // Reset the form
    post.title = '';
    post.body = '';
    post.thumbnail = null;
    // Optionally, you can redirect to the post details page or perform other actions.
  } catch (error) {
    console.error('Error creating post:', error);
  }
};
</script>
