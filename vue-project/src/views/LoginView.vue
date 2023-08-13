<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email:</label>
        <input type="text" id="email" v-model="email" />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from "../api.js";

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      // Fetch CSRF cookie
      await axios.get("/sanctum/csrf-cookie");

      const formData = {
        email: this.email,
        password: this.password,
      };

      axios
        .post("login", formData)
        .then((response) => {
          // Handle successful login
          const allCookies = document.cookie;
          console.log("All cookies:", allCookies);
          console.log("Login successful", response);
        })
        .catch((error) => {
          // Handle login error
          console.error("Login error", error);
        });

      const dat = await axios.get("/profile");
      const outp = JSON.stringify(dat);
      console.log(outp);
    },
  },
};
</script>

<style>
/* Add your component-specific styles here */
</style>
