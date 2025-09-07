<script setup lang="ts">
import { defineProps } from 'vue';
import { useTasks } from '@/stores/tasks';
import { toast } from 'sonner';

const props = defineProps<{ task: any }>();
const tasks = useTasks();

const updateStatus = async (newStatus: 'todo' | 'in_progress' | 'done') => {
  await tasks.update(props.task.id, { status: newStatus });
  toast.success(`Task status updated to "${newStatus}"`);
};

const removeTask = async () => {
  await tasks.remove(props.task.id);
  toast.success('Task deleted successfully!');
};
</script>

<template>
  <div class="rounded-2xl shadow p-4 border bg-white">
    <div class="flex items-center justify-between">
      <h3 class="font-semibold">{{ task.title }}</h3>
      <select v-model="task.status" @change="updateStatus(task.status)" class="border rounded px-2 py-1">
        <option value="todo">To-Do</option>
        <option value="in_progress">In Progress</option>
        <option value="done">Done</option>
      </select>
    </div>
    <p class="text-sm text-gray-600 mt-2">{{ task.description }}</p>
    <p class="text-xs text-gray-400 mt-1">Due: {{ task.due_at }}</p>
    <button @click="removeTask" class="mt-3 text-red-600">Delete</button>
  </div>
</template>
