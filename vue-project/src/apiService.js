// apiService.js
import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http:127.0.0.1:8000'
  // You can also add headers, interceptors, etc. here
});

export default {
  fetchData() {
    return apiClient.get('/posts');
  },
  // Add more API methods here
};
