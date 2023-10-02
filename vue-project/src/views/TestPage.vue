<template>
  <NavBar />
  <div class="container mx-auto mt-8 px-4">
    <div class="flex flex-wrap -mx-4">
      <!-- Right Column: Post Cards -->
      <div class="w-full md:w-3/4 px-4">
        <div class="grid grid-cols-1">
          <div v-for="post in posts" :key="post.id" class="bg-white rounded-lg p-4">
            <PostCard
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

// State
const selectedTags = ref([])
const posts = ref([])
const tags = ref([])
const author = null
const favorited = null

// Router
const router = useRouter()

// Fetch tags from the API
async function fetchTags() {
  try {
    const response = await api.getTags() // Replace with your API endpoint
    tags.value = response.data
  } catch (error) {
    console.error('Error fetching tags:', error)
  }
}

// Function to format an array as a comma-separated string
function formatTags(tagsArray) {
  return tagsArray.join(',')
}

// Fetch posts based on selected tags and page

const toggleTag = (tagName) => {
  if (selectedTags.value.includes(tagName)) {
    // Tag is already selected, so deselect it
    selectedTags.value = selectedTags.value.filter((tag) => tag !== tagName)
  } else {
    // Tag is not selected, so select it
    selectedTags.value.push(tagName)
  }

  // After toggling the tag, fetch posts based on selected tags
  fetchPosts(page.value) // You can pass the current page as an argument
}

async function afetchPosts(page) {
  const selectedTagNames = selectedTags.value

  try {
    let params = {
      page
    }

    // Only add 'tags' to params if selected tags are available
    if (selectedTagNames.length > 0) {
      params.tags = formatTags(selectedTagNames)
    }
    console.log('Fetch Posts Request Parameters:', params)

    const response = await api.getPosts(params)
        console.log(response.data.meta.last_page)

    posts.value = response.data.data
    page.value = response.data.meta.current_page
    last_page = response.data.meta.last_page


  } catch (error) {
    console.error('Error fetching posts:', error)
  }
}


async function fetchPosts(pageNumber) {
  const selectedTagNames = selectedTags.value

  try {
    let params = {
      page: pageNumber // Use the function parameter, not the ref variable
    }

    // Only add 'tags' to params if selected tags are available
    if (selectedTagNames.length > 0) {
      params.tags = formatTags(selectedTagNames)
    }
    console.log('Fetch Posts Request Parameters:', params)

    const response = await api.getPosts(params)
    posts.value = response.data.data
    page.value = response.data.meta.current_page
    last_page = response.data.meta.last_page

  } catch (error) {
    console.error('Error fetching posts:', error)
  }
}


// Initial data fetch
onMounted(async () => {
  await fetchTags(); // Wait for fetchTags to complete
  fetchPosts();
})
</script>
