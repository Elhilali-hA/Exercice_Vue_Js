import axios from 'axios';

const http = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    Accept: 'application/json',
  },
});

// Automatically attach token from localStorage
const token = localStorage.getItem('token');
if (token) {
  http.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default http;
