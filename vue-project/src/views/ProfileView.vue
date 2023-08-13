<template>
  <div>
    <h1>{{ profile.name }}</h1>
    <p>{{ profile.bio }}</p>
    <p>{{ profile.location }}</p>
    <img :src="profile.avatar_url" :alt="profile.name" />
  </div>
</template>

<script>
import axios from '../api.js';

export default {
  data() {
    return {
      profile: {},
    };
  },
  mounted() {
    this.fetchProfileData();
  },
  methods: {
    fetchProfileData() {

      axios.get("/profile")
        .then(response => {
          this.profile = response.data;
        })
        .catch(error => {
          console.error('Error fetching profile data:', error);
        });
    },
  },
};
</script>

<style>
/* Add your CSS styles here */
</style>
