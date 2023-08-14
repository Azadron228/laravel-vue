<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full">
      <form @submit.prevent="updateUser">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
          <input v-model="userData.name" type="text" id="name" class="form-input" />
        </div>
        <div class="mb-4">
          <label for="bio" class="block text-gray-700 font-bold mb-2">Bio:</label>
          <textarea v-model="userData.bio" id="bio" class="form-input"></textarea>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
          <input v-model="userData.password" type="password" id="password" class="form-input" />
        </div>
        <div class="mb-4">
          <label for="avatar" class="block text-gray-700 font-bold mb-2">Avatar URL:</label>
          <input v-model="userData.avatar" type="text" id="avatar" class="form-input" />
        </div>
        <div class="text-center">
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update User</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      userData: {
        name: '',
        bio: '',
        password: '',
        avatar: ''
      }
    };
  },
  methods: {
    updateUser() {
      // Send the updated data to your API using Axios
      axios.put('YOUR_API_ENDPOINT', this.userData)
        .then(response => {
          console.log('User data updated successfully:', response.data);
          // You can perform any necessary actions after the update here
        })
        .catch(error => {
          console.error('Error updating user data:', error);
          // Handle errors here
        });
    }
  }
};
</script>

<style>
/* Add your Tailwind CSS classes or customize the styling here */
</style>
