import { defineStore } from 'pinia';
import axios from '../api.js';

export const useUserStore = defineStore('user', {
  state: () => ({
    userInfo: null,
  }),

  actions: {
    updateUserInfo(userInfo) {
      // Update the local state
      this.userInfo = userInfo;

      // Save userInfo to localStorage for persistence
      localStorage.setItem('userInfo', JSON.stringify(userInfo));
    },

    async getUserInfo() {
      // Check if userInfo is already in local state
      if (this.userInfo) {
        return this.userInfo;
      }

      // Try to get userInfo from localStorage
      const storedUserInfo = localStorage.getItem('userInfo');
      if (storedUserInfo) {
        this.userInfo = JSON.parse(storedUserInfo);
        return this.userInfo;
      }

      // If not found in local state or localStorage, make an API request
      try {
        // Replace 'YOUR_API_ENDPOINT' with your actual API endpoint
        const response = await axios.get('/profile');
        console.log(response);
        this.userInfo = response.data;
        localStorage.setItem('userInfo', JSON.stringify(response.data));
        return response.data;
      } catch (error) {
        console.error('Error fetching user info:', error);
        return null;
      }
    },
  },
});
