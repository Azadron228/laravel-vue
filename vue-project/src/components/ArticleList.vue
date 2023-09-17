<script setup>
  import article-preview from './ArticlePreview.vue'
</script>

<template>
  <div v-if="error" class="article-preview">Articles is error</div>
  <div v-else-if="isLoading" class="article-preview">Loading articles...</div>
  <div v-else-if="state.articles.length === 0" class="article-preview">
    No articles are here... yet.
  </div>
  <div v-else class="article-list">
    <article-preview
      v-for="post in posts.data"
      :key="index"
      :article="article"
    />
    <article-pagination
      :current="articlesCurrent"
      :count="state.articlesCount"
      @current-change="handleCurrentChang"
    />
  </div>

  <div
      v-for="post in posts.data"
      :key="post.id"
      class="mb-4 max-w-md mx-auto bg-white rounded-xl overflow-hidden shadow-lg"
    >
      <img
        class="h-64 w-full object-cover object-center"
        src="post.thumbnail"
        alt="Post Thumbnail"
      />

      <div class="p-6">
        <div class="font-semibold text-2xl mb-2">{{ post.title }}</div>
        <router-link :to="'/profile/' + post.author.username" class="text-blue-500 hover:underline">
          By {{ post.author.username }}
        </router-link>
        <div class="flex justify-between mt-4">
          <div class="flex items-center space-x-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-500 mr-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <!-- Your SVG path here -->
            </svg>
            <span class="text-gray-500">{{ post.likes }} Likes</span>
          </div>
          <div class="flex items-center space-x-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-500 mr-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <!-- Your SVG path here -->
            </svg>
            <span class="text-gray-500">{{ post.comments }} Comments</span>
            <router-link :to="'/post/' + post.id" class="text-blue-500 hover:underline">
              Read more
            </router-link>
          </div>
          <!-- Tags List -->
          <div class="mt-4">
            <div class="flex flex-wrap">
              <span class="text-gray-500 mr-2">Tags:</span>
              <div v-for="tag in post.tags">
                <span
                  :key="tag"
                  class="bg-blue-200 text-blue-700 rounded-full px-2 py-1 text-xs font-semibold mr-2"
                >
                  {{ tag }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
