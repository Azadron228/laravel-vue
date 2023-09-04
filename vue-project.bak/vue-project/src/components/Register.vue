<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold mb-4">Register</h2>
      <form @submit.prevent="registerUser">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium">Name</label>
          <input v-model="name" type="text" id="name" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium">Email</label>
          <input v-model="email" type="email" id="email" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium">Password</label>
          <input v-model="password" type="password" id="password" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
          <input v-model="password_confirmation" type="password" id="password_confirmation" class="mt-1 p-2 w-full border rounded-md">
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

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    };
  },
  methods: {
    async registerUser() {
      if (this.password !== this.password_confirmation) {
        console.error('Password and confirmation do not match');
        return;
      }

      try {
        const response = await axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        this.$router.push('/');
        // Handle successful registration (e.g., show success message or redirect)
        console.log('User registered:', response.data);
      } catch (error) {
        // Handle registration error (e.g., show error message)
        console.error('Registration error:', error.response.data);
      }
    },
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
