
<template>
  <NavBar/>
  <div class="container mx-auto mt-8 px-4">
    <div class="flex mx-8">
      <!-- Right Column: Post Cards -->
      <div class="w-full mr-7">
        <div class="grid grid-cols-1 gap-6">
          <div v-for="post in posts" :key="post.id" class="bg-white rounded-lg p-4">
            <PostCard
              thumbnail="https://via.placeholder.com/150"
              :title="post.title"
              :author="post.authorname"
              :likes="post.favorites"
              :description="post.description"
              :tags="['sqlite', 'wasm', 'duckdb', 'benchmarks']"
            />
          </div>
        </div>
      </div>

      <!-- Left Column: Select Tags -->
      <div class="w-1/4">
        <div class="bg-white rounded-lg p-4">
          <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Select Tags:</label>
          <select v-model="selectedTags" id="tags" multiple class="w-full px-4 py-2 border rounded">
            <option v-for="tag in tags.data" :key="tag.name" :value="tag.name">
              {{ tag.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div>
    <!-- Your content here -->
    <Pagination :page="currentPage" :last_page="lastPage" @page-change="handlePageChange" />
  </div>

      <div class="flex justify-center">

  <Pagination
      :current_page="page"
      :last_page="last_page"
      @current-change="handleCurrentChang"
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


const page = ref(1);
const last_page = ref(9);

const handleCurrentChang = (newPage) => {
  page.value = newPage;
  fetchPosts(page.value);
  console.log(page.value)
};

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

async function fetchPosts(page) {
  //const page = router.currentRoute.value.query.page || 1 // Get page from query parameter
  const selectedTagNames = selectedTags.value

  try {
    let params = { page } // Initialize params with 'page'

    // Only add 'tags' to params if selected tags are available
    if (selectedTagNames.length > 0) {
      params.tags = formatTags(selectedTagNames)
    }

    const response = await api.getPosts(page)
    posts.value = response.data.data
  } catch (error) {
    console.error('Error fetching posts:', error)
  }
}

// Initial data fetch
fetchTags()
onMounted(() => {
  fetchTags(), fetchPosts()
})
</script>
