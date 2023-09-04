<template>
  <div>
    <button @submit.prevent="posts">Fetch Data</button>
    <div v-if="isLoading">Loading...</div>
    <div v-else>
      <ul>
        <li v-for="item in data" :key="item.id">{{ item.name }}</li>
      </ul>
    </div>
  </div>
</template>

<script>
import apiService from '../api/index.js'; // Import the API service

const posts = async () => {
  const result = await apiService.fetchData();
  console.log(result);
}
</script>

