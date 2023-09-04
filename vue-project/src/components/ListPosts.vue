<template>
  <div class="container mx-auto px-4 py-8">
    <div v-for="post in posts.data" :key="post.id">
      <div class="max-w-md mx-auto bg-white rounded-xl overflow-hidden shadow-lg">
        <img class="h-48 w-full object-cover object-center" src="https://w.wallhaven.cc/full/4o/wallhaven-4oq6p0.png"
          alt="Post Thumbnail" />
        <div class="p-6">
          <div class="font-semibold text-2xl mb-2">{{ post.title }}</div>
          <router-link :to="'/profile/' + post.author.username" class="text-blue-500 hover:underline">By {{
            post.author.username }}</router-link>
          <div class="flex justify-between">
            <div class="flex items-center space-x-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M5 2a2 2 0 012-2h6a2 2 0 012 2v2h2a2 2 0 012 2v11a2 2 0 01-2 2H3a2 2 0 01-2-2V6c0-1.1.9-2 2-2h2V2zm0 2v1h10V4H5zm0 2v2h10V6H5zm0 3v2h6V9H5zm0 3v2h6v-2H5zm0 3v2h6v-2H5zm8-9v6h2V9h-2z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-gray-500">{{ post.likes }} Likes</span>
            </div>
            <div class="flex items-center space-x-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a.9.9 0 01-.9-.9V10.9A.9.9 0 0110 10h6.1a.9.9 0 01.9.9v6.2a.9.9 0 01-.9.9H10zM7 10.9a.9.9 0 00-.9.9V17H2V7h5v3.9zM18 0H2a2 2 0 00-2 2v16a2 2 0 002 2h8l4 4 4-4h2a2 2 0 002-2V2a2 2 0 00-2-2zm0 18H10V2h8v16z" />
              </svg>
              <span class="text-gray-500">{{ post.comments }} Comments</span>
              <router-link :to="'/post/' + post.id" class="text-blue-500 hover:underline">Read more</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-6">
      <TailwindPagination :data="posts" @pagination-change-page="getPosts" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import api from '../api/index.js'
import { TailwindPagination } from 'laravel-vue-pagination'

const posts = ref([])

async function getPosts(page = 1) {
  const fetchedPosts = await api.getPosts(page)
  posts.value = fetchedPosts.data
  console.log(fetchedPosts.data)
}
onMounted(() => {
  getPosts()
})
</script>
