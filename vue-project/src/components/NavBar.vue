




<template>
  <nav class="bg-gray-800 p-4">
    <div class="container flex justify-between items-center w-full">
      <div class="text-white font-semibold text-xl">My App</div>
      <div class="flex space-x-4">
        <a class="text-white hover:text-gray-300" href="#">Home</a>
        <a class="text-white hover:text-gray-300" href="/update-user">UpdateUser</a>
        <template v-if="userStore.user.isLoggedIn">
          <span class="text-white">{{ userStore.user.name }}</span>
        </template>
        <template v-else>
          <a class="text-white hover:text-gray-300" href="/login">Log in</a>
          <a class="text-white hover:text-gray-300" href="/register">Register</a>
        </template>
      </div>
    </div>
  </nav>
</template>

<script>
import { useUserStore } from '@/stores/userStore.js';

export default {
  name: 'Navbar',
  computed: {
    userStore() {
      return useUserStore();
    },
  },
};
</script>

<style scoped>
/* You can add custom styles here if needed */
</style>

