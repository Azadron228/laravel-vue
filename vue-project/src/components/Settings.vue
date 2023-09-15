<template>
  <div class="max-w-3xl mx-auto mt-6 p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold">Update Your Profile</h1>
    <form @submit.prevent="updateUser">
      <div class="mb-4">
        <label for="username" class="block font-semibold">Username</label>
        <input v-model="userInfo.username" type="text" id="username" class="w-full px-3 py-2 border rounded">
      </div>
      <div class="mb-4">
        <label for="bio" class="block font-semibold">Bio</label>
        <input v-model="userInfo.bio" type="text" id="bio" class="w-full px-3 py-2 border rounded">
      </div>
      <div class="mb-4">
        <label for="email" class="block font-semibold">Email</label>
        <input v-model="userInfo.email" type="email" id="email" class="w-full px-3 py-2 border rounded">
      </div>
      <div v-if="userInfo.avatar">
        <img :src="userInfo.avatar" alt="User Avatar" class="rounded-full mb-4">
      </div>
      <div class="mb-4">
        <label for="avatar" class="block font-semibold">Avatar</label>
        <input type="file" ref="fileInput" id="avatar" @change="handleAvatarUpload">
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update profile</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/index.ts'
import { useUserStore } from '@/stores/userStore.ts';

const userStore = useUserStore();
const userInfo = ref({
  username: '',
  email: '',
  avatar: null, 
  bioL: '',
  _method: 'PUT',
});
onMounted(async () => {
  userInfo.value.username = userStore.userInfo.username;
  userInfo.value.email = userStore.userInfo.email;
  userInfo.value.avatar = userStore.userInfo.avatar;
  userInfo.value.bio= userStore.userInfo.bio;
});

const handleAvatarUpload = (e) => {
  userInfo.value.avatar = e.target.files[0];
};

const updateUser = async () => {
  try {
    const response = await api.updateUser(userInfo.value);
    userStore.updateUserInfo(response.data.user);
    console.log(response.data);
  } catch (error) {
    console.error(error);
  }
};
</script>
