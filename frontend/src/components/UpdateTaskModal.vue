<script setup lang="ts">
import { ref, watch } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import type { Task } from '@/stores/tasks'

const props = defineProps<{
  task: Task | null
  visible: boolean
  onClose: () => void
  onUpdate: (task: Task) => void
}>()

// Local state for modal inputs
const title = ref('')
const description = ref('')
const status = ref<'todo' | 'pending' | 'done'>('todo')

// Sync inputs whenever task prop changes
watch(
  () => props.task,
  (task) => {
    if (task) {
      title.value = task.title
      description.value = task.description ?? ''
      status.value = task.status
    }
  },
  { immediate: true }
)

// Emit updated task
const handleUpdate = () => {
  if (!props.task) return
  props.onUpdate({
    ...props.task,
    title: title.value,
    description: description.value,
    status: status.value,
  })
  props.onClose()
}
</script>

<template>
  <!-- Overlay -->
  <div
    v-if="props.visible"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
  >
    <!-- Modal -->
    <div
      class="bg-white  rounded-xl shadow-xl w-full max-w-md p-6 animate-in fade-in zoom-in"
    >
      <h2 class="text-xl font-semibold mb-4 text-center">Edit Task</h2>

      <div class="flex flex-col gap-4">
        <Input v-model="title" placeholder="Title" />
        <Input v-model="description" placeholder="Description" />

        <!-- Simple Select -->
        <select
          v-model="status"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        >
          <option value="todo">Todo</option>
          <option value="pending">In Progress</option>
          <option value="done">Done</option>
        </select>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <Button variant="secondary" @click="props.onClose">Cancel</Button>
        <Button class="bg-blue-500 hover:bg-blue-600 text-white" @click="handleUpdate">
          Update
        </Button>
      </div>
    </div>
  </div>
</template>
