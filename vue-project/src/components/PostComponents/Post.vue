<template>
  <div class="max-w-md mx-auto mt-4 p-4">
    <h2 class="text-xl font-semibold mb-2">{{ post.title }}</h2>
    <p class="text-gray-600">{{ post.body}}</p>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import api from '@/api/index.js'
import { useRoute } from 'vue-router';

const post = ref([])
const route = useRoute(); 
const postId = route.params.id;
console.log(postId);
async function getPost(postId) {
  const fetchedPosts = await api.getPost(postId);
  post.value = fetchedPosts.data.post
  console.log(fetchedPosts)
}
onMounted(() => {
getPost(postId);
})
</script>
