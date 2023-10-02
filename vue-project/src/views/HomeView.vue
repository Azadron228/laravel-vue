<template>
  <NavBar />
  <div class="container mx-auto mt-8 px-4">
    <div class="flex flex-wrap -mx-4">
      <!-- Right Column: Post Cards -->
      <div class="w-full md:w-3/4 px-4">
        <div class="grid grid-cols-1">
          <div v-for="post in posts" :key="post.id" class="bg-white rounded-lg p-4">
            <PostCard
              :slug="post.slug"
              :title="post.title"
              :author="post.authorname"
              :likes="post.favorites"
              :description="post.description"
              :tags="['sqlite', 'wasm', 'duckdb', 'benchmarks']"
            />
          </div>
        </div>
      </div>

      <div class="w-full md:w-1/4 px-4 mt-6 md:mt-0">
        <div class="bg-white p-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Select Tags:</label>
          <div class="flex flex-wrap">
            <button
              v-for="tag in tags.data"
              :key="tag.name"
              :class="{
                'bg-blue-500 text-white': selectedTags.includes(tag.name),
                'bg-gray-200 text-gray-700': !selectedTags.includes(tag.name)
              }"
              @click="toggleTag(tag.name)"
              class="w-full mb-1 rounded-sm px-2 py-2 border focus:outline-none focus:ring focus:border-blue-300"
            >
              <span class="overflow-hidden overflow-ellipsis whitespace-nowrap">{{
                tag.name
              }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center mt-4">
      <Pagination
        :current_page="page"
        :last_page="last_page"
        @current-change="handleCurrentChange"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api/index.ts'
import PostCard from '@/components/ArticlePreview.vue'
import NavBar from '@/components/TheHeader.vue'
import Pagination from '../components/Pagination.vue'

const page = ref(1)
let last_page = ref()

const handleCurrentChange = (newPage) => {
  page.value = newPage
  fetchPosts(page.value)
}

const selectedTags = ref([])
const posts = ref([])
const tags = ref([])
const author = null
const favorited = null

const router = useRouter()

async function fetchTags() {
  try {
    const response = await api.getTags() 
    tags.value = response.data
  } catch (error) {}
}

function formatTags(tagsArray) {
  return tagsArray.join(',')
}

const toggleTag = (tagName) => {
  if (selectedTags.value.includes(tagName)) {
    selectedTags.value = selectedTags.value.filter((tag) => tag !== tagName)
  } else {
    selectedTags.value.push(tagName)
  }
  fetchPosts(page.value) 
}

async function fetchPosts(pageNumber) {
  const selectedTagNames = selectedTags.value
  try {
    let params = {
      page: pageNumber
    }
    if (selectedTagNames.length > 0) {
      params.tags = formatTags(selectedTagNames)
    }
    const response = await api.getPosts(params)
    posts.value = response.data.data
    page.value = response.data.meta.current_page
    last_page = response.data.meta.last_page
  } catch (error) {}
}

onMounted(() => {
  fetchTags(), fetchPosts()
})
</script>
