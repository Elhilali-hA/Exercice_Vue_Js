<script setup lang="ts">
import { Card, CardHeader, CardTitle, CardContent, CardFooter, CardAction } from '@/components/ui/card'
import type { Task } from '@/stores/tasks'  

const props = defineProps<{
  task: Task
  onDelete: (id: number) => void
  onEdit: (task: Task) => void
}>()

const badgeClass = (status: Task['status']) => {
  switch (status) {
    case 'todo': return 'bg-gray-200 text-gray-800'
    case 'pending': return 'bg-yellow-200 text-yellow-800'
    case 'done': return 'bg-green-200 text-green-800'
  }
}
</script>

<template>
  <Card class="w-full max-w-sm shadow-md hover:shadow-lg transition bg-slate-800 text-white">
    <CardHeader>
      <CardTitle>{{ props.task.title }}</CardTitle>
      <CardAction>
        <button
          class="text-red-500 hover:text-red-700 font-bold"
          @click="props.onDelete(props.task.id)"
          style="cursor: pointer;"
        >
          Delete
        </button>
      </CardAction>
    </CardHeader>

    <CardContent>
      <p class="text-gray-600 pb-3 text-white">
        {{ props.task.description || 'No description' }}
      </p>
      
    </CardContent>

    <CardFooter class="flex justify-between">
      <span
        :class="['inline-block px-2 py-1 rounded text-sm font-semibold ', badgeClass(props.task.status)]"
      >
        {{ props.task.status }}
      </span>
      <button
        class="bg-slate-500 text-white px-4 py-1 rounded hover:bg-slate-600"
        @click="props.onEdit(props.task)"
        style="cursor: pointer"
      >
        Edit
      </button>
    </CardFooter>
  </Card>
</template>
