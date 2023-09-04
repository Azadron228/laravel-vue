






<template>
  <nav>
    <div class="bg-gray-800 p-4">
      <span class="text-white text-lg font-semibold">My App</span>
      <div class="flex items-center space-x-4">
        <span v-if="userStore.userInfo" class="text-white">Hello, {{ userStore.userInfo.name }}</span>
        <a v-else href="/login" class="text-blue-500 hover:underline">Login</a>
      </div>
    </div>
  </nav>
</template>

<script>
import { useUserStore } from '../stores/userStore.ts'; // Adjust the path to your store
import { onMounted } from 'vue';

export default {
  name: 'Navbar',
  setup() {
    const userStore = useUserStore();

    userStore.getUserInfo();

    return { userStore };
  },
};
</script>

<style>
/* Your CSS styling for the navbar */
</style>

