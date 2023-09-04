import axios from 'axios'

const axiosInstane = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Content-Type': 'multipart/form-data',
  },
});

export default axiosInstane;
