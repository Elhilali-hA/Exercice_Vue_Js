<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useTasks } from '@/stores/tasks'
import TaskCard from '@/components/TaskCard.vue'
import type { Task } from '@/stores/tasks'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Button } from "@/components/ui/button"
import UpdateTaskModal from '@/components/UpdateTaskModal.vue'
import { useAuth } from '@/stores/auth'
import router from '@/router'


const auth = useAuth();
const tasksStore = useTasks()
const selectedTask = ref<Task | null>(null)
const isModalVisible = ref(false)

const title = ref('')
const description = ref('')
const status = ref<'todo' | 'pending' | 'done'>('todo')



onMounted(async () => {
  if (!auth.token) {
    router.push('/login')
  }
  await tasksStore.fetch()
})



const addTask = async () => {
  if (!title.value) return alert('Title is required')

  await tasksStore.create({
    title: title.value,
    description: description.value,
    status: status.value,
  })

  // Reset form
  title.value = ''
  description.value = ''
  status.value = 'todo'
}

const editTask = (task: Task) => {
  selectedTask.value = task
  isModalVisible.value = true
}

const updateTask = async (updated: Task) => {
  await tasksStore.update(updated.id, updated)
  await tasksStore.fetch()
}


const deleteTask = async (id: number) => {
  if (confirm("Are you sure you want to delete this task?")) {
  await tasksStore.remove(id)
  }
}


</script>

<template>
  <div class="container py-5 bg-sky-200">
    <div class="flex justify-between items-center mb-6 p-3">
      <h1 class="text-2xl font-bold">
        Welcome, <span class="text-white">{{ auth.user?.name }}</span>
      </h1>

      <button
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
        @click="auth.logout"
      >
        Logout
      </button>
    </div>
    <h1 class="text-center mb-4 text-xl font-bold">To Do List</h1>

    <!-- Add Task Form -->
    <!-- <div class="card mb-4 p-3">
      <h5>Add New Task</h5>
      <div class="mb-2">
        <input v-model="title" type="text" class="form-control" placeholder="Title" />
      </div>
      <div class="mb-2">
        <input v-model="description" type="text" class="form-control" placeholder="Description" />
      </div>
      <div class="mb-2">
        <select v-model="status" class="form-select">
          <option value="todo">Todo</option>
          <option value="pending">In Progress</option>
          <option value="done">Done</option>
        </select>
      </div>
      <button class="btn btn-primary" @click="addTask">Add Task</button>
    </div> -->


     <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <Card class="w-full max-w-md shadow-lg">
          <CardHeader>
            <CardTitle class="text-xl font-semibold text-center">
              Add New Task
            </CardTitle>
          </CardHeader>

          <CardContent class="space-y-4">
            <Input
              v-model="title"
              placeholder="Title"
              class="w-full"
            />

            <Input
              v-model="description"
              placeholder="Description"
              class="w-full"
            />

            <select
              v-model="status"
              class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
              <option value="todo">Todo</option>
              <option value="pending">In Progress</option>
              <option value="done">Done</option>
            </select>
          </CardContent>

          <CardFooter class="flex justify-center">
            <Button @click="addTask" class="w-full bg-cyan-100" >
              Add Task
            </Button>
          </CardFooter>
        </Card>
      </div>

    <!-- Tasks List -->
    <h1 class="text-center mb-4 text-xl font-bold py-4">Tasks</h1>
    <div class="flex justify-center">
    <div v-if="tasksStore.list.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl w-full">
      <TaskCard
        v-for="task in tasksStore.list"
        :key="task.id"
        :task="task"
        :onDelete="deleteTask"
        :onEdit="editTask"
      />
    </div>

    <div v-else class="text-center text-gray-500 py-10">
      No tasks found 🚀
    </div>
  </div>

  <UpdateTaskModal
      :task="selectedTask"
      :visible="isModalVisible"
      :onClose="() => (isModalVisible = false)"
      :onUpdate="updateTask"
    />
  </div>
</template>
