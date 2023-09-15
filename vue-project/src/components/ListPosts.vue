<template>
  <div class="container mx-auto px-4 py-8">
    <div class="grid grid-rows-2">
      <div class="mb-4 flex space-x-4">
        <p>This is all Tags</p>
        <button
          v-for="tag in allTags"
          :key="tag"
          @click="toggleTagFilter(tag)"
          :class="{
            'bg-blue-500 text-white': selectedTags.includes(tag),
            'bg-gray-200 text-gray-700': !selectedTags.includes(tag)
          }"
          class="px-3 py-1 rounded-full focus:outline-none"
        >
          {{ tag }}
        </button>
      </div>

      <!-- List of all Tags -->
    </div>
    <div
      v-for="post in posts.data"
      :key="post.id"
      class="mb-4 max-w-md mx-auto bg-white rounded-xl overflow-hidden shadow-lg"
    >
      <img
        class="h-64 w-full object-cover object-center"
        src="post.thumbnail"
        alt="Post Thumbnail"
      />

      <div class="p-6">
        <div class="font-semibold text-2xl mb-2">{{ post.title }}</div>
        <router-link :to="'/profile/' + post.author.username" class="text-blue-500 hover:underline">
          By {{ post.author.username }}
        </router-link>
        <div class="flex justify-between mt-4">
          <div class="flex items-center space-x-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-500 mr-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <!-- Your SVG path here -->
            </svg>
            <span class="text-gray-500">{{ post.likes }} Likes</span>
          </div>
          <div class="flex items-center space-x-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-500 mr-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <!-- Your SVG path here -->
            </svg>
            <span class="text-gray-500">{{ post.comments }} Comments</span>
            <router-link :to="'/post/' + post.id" class="text-blue-500 hover:underline">
              Read more
            </router-link>
          </div>
          <!-- Tags List -->
          <div class="mt-4">
            <div class="flex flex-wrap">
              <span class="text-gray-500 mr-2">Tags:</span>
              <div v-for="tag in post.tags">
                <span
                  :key="tag"
                  class="bg-blue-200 text-blue-700 rounded-full px-2 py-1 text-xs font-semibold mr-2"
                >
                  {{ tag }}
                </span>
              </div>
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

<script setup lang="ts">
import { ref, onMounted, computed, defineProps } from 'vue'
import api from '../api/index.js'
import { TailwindPagination } from 'laravel-vue-pagination'

// Define props to make the component more reusable
const props = defineProps({
  author: String,
  favorited: String
})

const posts = ref([])
const currentPage = ref(1)
const allTags = ref([])
const selectedTags = ref([])

const paginationData = computed(() => {
  return {
    current_page: currentPage.value,
    author: props.author,
    favorited: props.favorited
  }
})

async function ggetPosts(page = 1) {
  currentPage.value = page
  const fetchedPosts = await api.getPosts(page, props.author, props.favorited)
  posts.value = fetchedPosts.data.data
}

async function getTags() {
  const fetchedTags = await api.getTags()
  allTags.value = fetchedTags.data
  console.log(fetchedTags)
}

const getPosts = async (page = 1) => {
  const response = await api.getPosts(page, props.author, props.favorited)
  posts.value = response.data
}

onMounted(() => {
  getPosts(), getTags()
})
</script>
