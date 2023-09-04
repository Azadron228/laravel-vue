import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', () => {
  const userInfo = ref(JSON.parse(localStorage.getItem('user')) || {})
  
  const updateUserInfo = (user) => {
    userInfo.value = user;
    localStorage.setItem('user', JSON.stringify(user));
  }

   const isLoggedIn = computed(() => {
    return Object.keys(userInfo.value).length > 0; // Check if userInfo has any data
  });

  return { userInfo, isLoggedIn, updateUserInfo }
})
