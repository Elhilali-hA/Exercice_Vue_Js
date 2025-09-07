import { defineStore } from 'pinia';
import http from '@/api/http';
import { useTasks } from './tasks';
import router from '@/router'


interface User { id:number; name:string; email:string; image?:string }

export const useAuth = defineStore('auth', {
  state: () => ({ user:null as User|null, token: localStorage.getItem('token') || '' }),
  actions: {
    async login(email:string, password:string){
      const { data } = await http.post('http://localhost:8000/api/auth/login', { email, password });
      this.user = data?.user;
      this.token = data?.authorisation?.token;
      localStorage.setItem('token', this.token);

      const tasks = useTasks();
      tasks.setToken(this.token);
    },
    async register(payload: FormData){
      const { data } = await http.post('http://localhost:8000/api/auth/register', payload, { headers:{'Content-Type':'multipart/form-data'} });
      this.user = data.user;
      this.token = data.token;
      localStorage.setItem('token', this.token);
    },
    logout() {
      this.user = null
      this.token = ''
      localStorage.removeItem('token')
      router.push('/login') // redirect to login page
    }
  }
});
