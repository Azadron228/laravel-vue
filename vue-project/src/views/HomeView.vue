<script setup lang="ts">
  import Navbar from '../components/NavBar.vue'
  import PostsPaginator from '../components/PostPagination.vue'
</script>

<template>
    <Navbar />
  <div>
    <h1 class="text-2xl font-bold mb-4">Posts</h1>
    <PostsPaginator />
  </div>
</template>
