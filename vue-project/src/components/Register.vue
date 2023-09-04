<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold mb-4">Register</h2>
      <form @submit.prevent="registerUser">
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium">Name</label>
          <input v-model="formStore.username" type="text" id="username" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium">Email</label>
          <input v-model="formStore.email" type="email" id="email" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium">Password</label>
          <input v-model="formStore.password" type="password" id="password" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
          <input v-model="formStore.password_confirmation" type="password" id="password_confirmation" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
          <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api/index.ts'
import { useUserStore } from '../stores/userStore.ts'; // Adjust the path as needed

const router = useRouter();
const userStore = useUserStore();

const formStore = ref({ username: '', email: '', password: '', password_confirmation: '' })

const registerUser = async () => {
  try {
    const response = await api.register({ user: formStore.value }); 
    console.log(response.data.user);
    userStore.updateUserInfo(response.data.user);
    router.push('/');
  } catch (error) {
    // Handle login error here
  }
};
</script>

