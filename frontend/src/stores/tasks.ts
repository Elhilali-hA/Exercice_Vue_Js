import { defineStore } from 'pinia';
import http from '@/api/http';

export interface Task {
  id: number;
  title: string;
  description?: string;
  status: 'todo' | 'pending' | 'done';
  due_at?: string | null;      
  completed_at?: string | null; 
}


export const useTasks = defineStore('tasks', {
  state: () => ({
    list: [] as Task[],
    loaded: false,
  }),
  actions: {
    setToken(token: string) {
      http.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    async fetch() {
      const { data } = await http.get('/tasks');
      console.log('data', data)
      this.list = data;
      this.loaded = true;
    },
    async create(task: Partial<Task>) {
      const { data } = await http.post('/tasks', task);
      this.list.unshift(data);
    },
    async update(id: number, task: Partial<Task>) {
      const { data } = await http.put(`/tasks/${id}`, task);
      const index = this.list.findIndex(t => t.id === id);
      if (index > -1) this.list[index] = data;
    },
    async remove(id: number) {
      await http.delete(`/tasks/${id}`);
      this.list = this.list.filter(t => t.id !== id);
    },
  },
});

