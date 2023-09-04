<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full p-6 bg-white shadow-md rounded-lg">
      <h1 class="text-2xl font-semibold mb-4">Login</h1>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label class="block text-gray-600 text-sm mb-1" for="email">Email</label>
          <input v-model="formStore.email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-400" type="text" id="email" placeholder="Email">
        </div>
        <div class="mb-6">
          <label class="block text-gray-600 text-sm mb-1" for="password">Password</label>
          <input v-model="formStore.password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-400" type="password" id="password" placeholder="Password">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Login</button>
      </form>
      <div class="mt-4 text-center">
        <p class="text-gray-600">Don't have an account? <router-link to="/register" class="text-blue-500 hover:underline">Register</router-link></p>
      </div>
      <div v-if="userStore.isLogged">
    <p>Welcome, {{ userStore.userInfo.email }}</p>
  </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import api from '../api/index.ts'
import { useUserStore } from '../stores/userStore.ts'; // Adjust the path as needed
import { useRouter } from 'vue-router';

const router = useRouter();
const userStore = useUserStore();

const formStore = ref({ email: '', password: '' })

const login = async () => {
  try {
    const response = await api.login({ user: formStore.value }); 
    console.log(response.data.user);
    userStore.updateUserInfo(response.data.user);
    router.push('/');
  } catch (error) {
    // Handle login error here
  }
};
</script>

