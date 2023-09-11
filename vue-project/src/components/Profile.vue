<template>
  <div v-if="isLoggedIn" class="w-full text-center">
    <div class="flex items-center flex-col mb-10 bg-sky-400 shadow-md">
      <img
        src="https://upload.wikimedia.org/wikipedia/en/thumb/f/f7/JoJo_no_Kimyou_na_Bouken_cover_-_vol1.jpg/220px-JoJo_no_Kimyou_na_Bouken_cover_-_vol1.jpg"
        alt="Avatar"
        class="w-40 h-40 rounded-full mb-2 mt-4"
      />
      <h3 class="text-xl font-semibold mb-2">{{ userInfo.username }}</h3>
      <p class="text-gray-600 text-sm mb-4">{{ userInfo.email }}</p>
    </div>
    <div class="flex justify-center">
      <p class="text-m max-w-prose">{{ userInfo.bio }}</p>
    </div>
  </div>

  <div class="mt-4">
    <ul class="flex justify-center">
      <li
        @click="setActiveTab('yourPosts')"
        :class="{ 'active-tab': activeTab === 'yourPosts' }"
        class="cursor-pointer px-4 py-2 shadow rounded hover:bg-gray-300"
      >
        Your Posts
      </li>
      <li
        @click="setActiveTab('favoritedPosts')"
        :class="{ 'active-tab': activeTab === 'favoritedPosts' }"
        class="cursor-pointer shadow px-4 py-2 hover:bg-gray-300"
      >
        Favorited Posts
      </li>
    </ul>
  </div>

  <div v-if="activeTab === 'yourPosts'">
    <p class="text-center mt-4">Your Posts</p>
        <ListPosts :author="selectedAuthor" :favorited="selectedFavorited" />
  </div>
  <div v-else-if="activeTab === 'favoritedPosts'">
    <p class=text-center mt-4>Favorited Posts</p>
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
