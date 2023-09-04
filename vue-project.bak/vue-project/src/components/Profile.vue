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
      <label class="block mb-2 font-semibold" for="avatar">Avatar:</label>
      <input type="file" ref="avatarInput" @change="handleAvatarUpload" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    
    <div class="mb-4">
      <label class="block mb-2 font-semibold" for="password">Password:</label>
      <input v-model="password" id="password" type="password" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>
    <div class="mb-4">
      <label class="block mb-2 font-semibold" for="password">Confirm Password:</label>
      <input v-model="password_confirmation" id="password_confirmation" type="password" class="w-full rounded-lg px-3 py-2 border focus:outline-none focus:border-blue-500" />
    </div>

    <button @click="updateProfile" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Update Profile</button>

    <button @click="logOut" class="px-4 py-2 bg-red-500 text-white rounded-lg">Log Out</button>
  </div>
</template>

<script>
import axios from '../api.js';
import { useUserStore } from '../stores/userStore.js';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      avatar: null,
    };
  },
  methods: {
    async fetchProfile() {
      try {
        const response = await axios.get('/profile'); // Replace with your API endpoint
        this.name = response.data.name;
        this.email = response.data.email;
        this.avatar = response.data.avatar;
        console.log(response.data);
      } catch (error) {
        console.error('Error fetching profile:', error);
      }
    },


    handleAvatarUpload(event) {
    // Update the avatar property with the selected file
    this.avatar = event.target.files[0];
    },

    async updateProfile() {
    try {
    const requestData = new FormData();
    requestData.append('name', this.name);
    requestData.append('email', this.email);

       
    if (this.avatar) {
      requestData.append('avatar', this.avatar); // Append the avatar file to FormData
    }
    // Check if the user is changing the password
    if (this.password && this.password === this.password_confirmation) {
      requestData.password = this.password;
      requestData.password_confirmation = this.password_confirmation;
    } else if (this.password || this.password_confirmation) {
      console.error('Passwords do not match.');
      return; // Exit the method if only one of the password fields is filled
    }

    const response = await axios.put('/profile', requestData); // Replace with your API endpoint

    console.log('Profile updated:', response);
    } catch (error) {
      console.error('Error updating profile:', error);
    }
    },
    async logOut() {
      try {
        const response = await axios.post('/logout'); // Replace with your API endpoint
        
        const userStore = useUserStore();
        userStore.updateUserInfo(null);
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
