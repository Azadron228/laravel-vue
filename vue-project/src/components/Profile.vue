
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
      <h2 class="text-3xl font-semibold mb-4 text-center">Profile Page</h2>
      <div v-if="isLoggedIn" class="text-center">
        <div class="flex items-center flex-col mb-4">
          <img :src="'http://127.0.0.1:8000' + userInfo.avatar" alt="Avatar" class="w-24 h-24 rounded-full mb-2">
          <h3 class="text-xl font-semibold">{{ userInfo.username }}</h3>
          <p class="text-gray-600 text-sm">{{ userInfo.email }}</p>
        </div>
        <p class="text-center text-gray-700">{{ userInfo.bio }}</p>
        <button @click="logout"
          class="bg-red-500 text-white px-4 py-2 rounded mt-4 hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300">
          Logout
        </button>
      </div>
      <div v-else>
        <p class="text-center text-gray-700">You are not logged in.</p>
      </div>
    </div>
  </div>
</template>



<script setup>
import { useUserStore } from '../stores/userStore.ts'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const userInfo = userStore.userInfo
const isLoggedIn = userStore.isLoggedIn

const router = useRouter()

const logout = () => {
  userStore.updateUserInfo(null)
  router.push('/') // Redirect to the login page after logout
}
</script>
