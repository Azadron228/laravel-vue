<template>
  <div class="max-w-md mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">User Profile</h1>
    
    <div class="mb-4">
      <label class="block mb-2 font-semibold" for="name">Name:</label>
      <input v-model="name" id="name" type="text" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    
    <div class="mb-4">
      <label class="block mb-2 font-semibold" for="email">Email:</label>
      <input v-model="email" id="email" type="email" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    
    <div class="mb-4">
      <input type="file" ref="avatarInput" @change="handleAvatarUpload" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
      <label class="block mb-2 font-semibold" for="avatar">Avatar (link):</label>
      <input v-model="avatar" id="avatar" type="text" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    
    <div class="mb-4">
      <label class="block mb-2 font-semibold" for="password">Password:</label>
      <input v-model="password" id="password" type="password" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    
    <button @click="updateProfile" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Update Profile</button>

    <button @click="logOut" class="px-4 py-2 bg-red-500 text-white rounded-lg">Log Out</button>
  </div>
</template>

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      name: '',
      email: '',
      avatar: '',
      password: ''
    };
  },
  methods: {
    async fetchProfile() {
      try {
        const response = await axios.get('/profile'); // Replace with your API endpoint
        this.name = response.data.name;
        this.email = response.data.email;
        this.avatar = response.data.avatar;
      } catch (error) {
        console.error('Error fetching profile:', error);
      }
    },
    async updateProfile() {
      try {
        const response = await axios.put('/profile', {
          name: this.name,
          email: this.email
        }); // Replace with your API endpoint
        
        console.log('Profile updated:', response.data);
      } catch (error) {
        console.error('Error updating profile:', error);
      }
    },
    async logOut() {
      try {
        const response = await axios.post('/logout'); // Replace with your API endpoint
        this.$router.push('/');
        
        console.log('Profile updated:', response.data);
      } catch (error) {
        console.error('Error updating profile:', error);
      }
    }
  },
  mounted() {
    this.fetchProfile();
  }
};
</script>
