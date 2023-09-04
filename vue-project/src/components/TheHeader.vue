<script lang="ts" setup>
import { useUserStore } from '@/stores/userStore'
import { storeToRefs } from 'pinia';
import { computed } from 'vue';

const store = useUserStore()
const { isLoggedIn, userInfo } = storeToRefs(store)
const navList = computed(() => [
  {
    label: 'Home',
    path: '/',
    show: true,
  },
  {
    label: 'Sign in',
    path: '/login',
    show: !isLoggedIn.value,
  },
  {
    label: 'Sign up',
    path: '/register',
    show: !isLoggedIn.value,
  },
  {
    label: 'New Article',
    path: '/post/create',
    show: isLoggedIn.value,
    icon: 'ion-compose',
  },
  {
    label: 'Settings',
    path: '/settings',
    show: isLoggedIn.value,
    icon: 'ion-gear-a',
  },
  {
    label: userInfo.value?.username,
    path: `/profile`,
    show: isLoggedIn.value,
    pic: userInfo.value?.avatar,
  },
])
</script>

<template>
  <nav class="bg-white shadow">
    <div class="container mx-auto py-4">
      <router-link class="text-xl font-bold text-blue-500" to="/">
        conduit
      </router-link>
      <ul class="flex items-center space-x-4 ml-auto">
        <template v-for="{ label, path, icon, pic, show } in navList" :key="label">
          <li v-if="show">
            <router-link :to="path" class="text-gray-600 hover:text-blue-500 transition">
              <template v-if="icon">
                <i :class="`${icon} text-base mr-1`"></i>
              </template>
              <template v-if="pic">
                <img :src="'http://127.0.0.1:8000' + pic" class="w-8 h-8 rounded-full" alt="User">
              </template>
              {{ label }}
            </router-link>
          </li>
        </template>
      </ul>
    </div>
  </nav>
</template>

