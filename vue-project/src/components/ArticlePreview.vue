<template>
  <div class="article-preview p-4 bg-white border-t-4 border-blue-500">
  <div class="article-preview mb-4 p-4 bg-white">
    <div class="article-meta flex items-center justify-between">
      <div class="flex items-center">
        <a href="/profile/Anah Benešová" class="inline-block">
          <img
            src="https://api.realworld.io/images/demo-avatar.png"
            class="rounded-full w-10 h-10"
          />
        </a>
        <div class="info ml-2">
          <a href="/profile/Anah Benešová" class="text-blue-500 font-semibold">{{ author }}</a>
          <p class="date text-gray-500">December 9, 2022</p>
        </div>
      </div>
      <button
        class="relative flex items-center rounded-sm text-blue-500 px-3 py-1 bg-blue-100 hover:bg-blue-200 hover:text-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="w-6 h-6"
        >
          <path
            d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"
          />
        </svg>
        {{ likes }}
      </button>
    </div>
    <router-link
        :to="'/post/' + slug"
      class="text-xl font-semibold text-gray-900 mt-2"
    >
      {{ title }}
    </router-link>

    <div class="mt-4">
      <div class="flex flex-wrap">
        <div v-for="tag in tags" :key="tag">
          <span class="text-gray-700 rounded-full px-2 py-1 text-xs font-semibold mr-2">{{
            tag
          }}</span>
        </div>
      </div>
    </div>

    <p class="text-gray-700 mt-4">
      {{ description }}
    </p>
    <span class="text-blue-500 mt-2 inline-block">Read more...</span>
  </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: String,
  description: String,
  author: String,
  likes: Number,
  comments: Number,
  tags: Array,
  slug: String,
})
</script>
