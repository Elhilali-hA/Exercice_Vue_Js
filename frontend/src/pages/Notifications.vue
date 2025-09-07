<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useAuth } from '@/stores/auth';
import { initEcho } from '@/plugins/echo';
import { toast } from 'sonner';

const auth = useAuth();
let sub: any;

onMounted(() => {
  const echo = initEcho();
  if(!echo || !auth.user) return;

  sub = echo.private(`user.${auth.user.id}`)
    .listen('.TaskCreated', (e:any) => {
      toast.success(`Task "${e.title}" created successfully!`);
    });
});

onBeforeUnmount(() => { if(sub && sub.stopListening) sub.stopListening('.TaskCreated'); });
</script>

<template>
  <div class="max-w-xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Notifications</h2>
    <p>Real-time notifications will appear as toast messages.</p>
  </div>
</template>
