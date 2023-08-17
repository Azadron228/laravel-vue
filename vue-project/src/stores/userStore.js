import { defineStore } from 'pinia';
import axios from '../api.js';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: {
      bio: '',
      avatar: '',
      name: '',
      isLoggedIn: false,
    },
  }),
  getters: {
    getUser: (state) => state.user,
  },
  actions: {
    async fetchUser() {
      try {
        const response = await axios.get('/profile');
        this.user = response.data;
        this.setLocalStorage();
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
    setLocalStorage() {
      localStorage.setItem('user', JSON.stringify(this.user));
    },
    loadFromLocalStorage() {
      const userData = localStorage.getItem('user');
      if (userData) {
        this.user = JSON.parse(userData);
      }
    },
    setUser(user) {
      this.user = user;
      this.setLocalStorage();
    },
  },
  actions: {
    onInit() {
      this.loadFromLocalStorage();
    },
  },
});
