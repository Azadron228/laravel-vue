<template>
  
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-2xl font-bold mb-4">Login</h2>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
          <input v-model="email" type="email" id="email" class="mt-1 p-2 w-full border rounded" />
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
          <input v-model="password" type="password" id="password" class="mt-1 p-2 w-full border rounded" />
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full">
          Login
        </button>
        <p class="text-red-500 mt-2" v-if="errorMessage">{{ errorMessage }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "../api.js";

export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    async login() {

      const formData = {
        email: this.email,
        password: this.password,
      };

      // Fetch CSRF cookie
      await axios.get("/sanctum/csrf-cookie");

      axios
        .post("/login", formData)
        .then((response) => {
          this.$router.push('/');
        })
        .catch((error) => {
          this.errorMessage = "Incorrect credentials. Please try again.";
        });
    },
  },
};
</script>


