<script setup lang="ts">
  import Navbar from '../components/NavBar.vue'
  import ListPosts from '../components/ListPosts.vue'
</script>

<template>
    <Navbar />
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="p-20 m-70 bg-white">
      <ListPosts />
    </div>
  </div>
</template>
