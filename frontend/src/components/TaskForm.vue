<script setup lang="ts">


import { ref } from 'vue';
import { useTasks } from '@/stores/tasks';
import { toast } from 'sonner';

const tasks = useTasks();

const title = ref('');
const description = ref('');
const status = ref<'todo' | 'in_progress' | 'done'>('todo');
const due_at = ref<string | null>('');;

const submit = async () => {
  if(!title.value) {
    toast.error('Title is required');
    return;
  }

  await tasks.create({
  title: title.value,
  description: description.value,
  status: status.value,
  due_at: due_at.value || null,
});

  toast.success('Task created successfully!');

  // Clear form
  title.value = '';
  description.value = '';
  status.value = 'todo';
  due_at.value = '';
};
</script>

<template>
  <div class="bg-white rounded-2xl shadow p-6 space-y-3">
    <h2 class="text-lg font-semibold">Add New Task</h2>
    <input v-model="title" placeholder="Title" class="border rounded w-full p-2" />
    <textarea v-model="description" placeholder="Description" class="border rounded w-full p-2"></textarea>
    <input v-model="due_at" type="datetime-local" class="border rounded w-full p-2" />
    <select v-model="status" class="border rounded w-full p-2">
      <option value="todo">To-Do</option>
      <option value="in_progress">In Progress</option>
      <option value="done">Done</option>
    </select>
    <button @click="submit" class="bg-blue-500 text-white px-4 py-2 rounded-2xl w-full">
      Add Task
    </button>
  </div>
</template>
