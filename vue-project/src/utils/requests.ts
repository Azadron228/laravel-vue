import axios from 'axios'

const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  withCredentials: true,
  headers: {
    'Content-Type': 'multipart/form-data',
    'Accept': 'application/json',
  },
})

// instance.interceptors.response.use(
//   ({ data }) => data,
//   ({ message, response }) => Promise.reject(response ? response.data : message)
// )

// instance.interceptors.response.use(
//   response => response,
//   error => {
//     console.error('Request error:', error);
//     return Promise.reject(error);
//   }
// );

export default instance
