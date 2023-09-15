<template>
  <div v-if="isLoggedIn" class="w-full text-center p-4">
    <div class="flex flex-col items-center mb-10 bg-sky-400 rounded-lg shadow-md p-4">
      <img
        src="userInfo.avatar"
        alt="Avatar"
        class="w-40 h-40 rounded-full mb-2"
      />
      <h3 class="text-2xl font-semibold mb-2">{{ userInfo.username }}</h3>
      <p class="text-gray-600 text-sm">{{ userInfo.email }}</p>
    </div>
    <div class="flex justify-center">
      <p class="text-lg text-gray-700">{{ userInfo.bio }}</p>
    </div>
  </div>

  <div class="mt-4">
    <ul class="flex justify-center space-x-4">
      <li
        @click="setActiveTab('yourPosts')"
        :class="{ 'bg-gray-300': activeTab === 'yourPosts' }"
        class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-200 transition"
      >
        Your Posts
      </li>
      <li
        @click="setActiveTab('favoritedPosts')"
        :class="{ 'bg-gray-300': activeTab === 'favoritedPosts' }"
        class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-200 transition"
      >
        Favorited Posts
      </li>
    </ul>
  </div>

  <div v-if="activeTab === 'yourPosts'" class="mt-4">
    <h2 class="text-2xl font-semibold text-center mb-4">Your Posts</h2>
    <ListPosts :author="selectedAuthor" :favorited="selectedFavorited" />
  </div>
  <div v-else-if="activeTab === 'favoritedPosts'" class="mt-4">
    <h2 class="text-2xl font-semibold text-center mb-4">Favorited Posts</h2>
    <ListPosts :author="selectedAuthor" :favorited="selectedFavorited" />
  </div>
</template>


<script setup>
import { useUserStore } from '../stores/userStore.ts'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import ListPosts from '@/components/ListPosts.vue'

const userStore = useUserStore()
const userInfo = userStore.userInfo
const isLoggedIn = userStore.isLoggedIn
const activeTab = ref('yourPosts')

const selectedAuthor = ref('Jotaro Kujo')
const selectedFavorited = ref(null)

const router = useRouter()

const setActiveTab = (tab) => {
  activeTab.value = tab
}
</script>
