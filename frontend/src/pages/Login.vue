<script setup lang="ts">
import { ref } from 'vue';
import { useAuth } from '@/stores/auth';
import { useRouter } from 'vue-router';

import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle
} from '@/components/ui/card';

const email = ref('');
const password = ref('');
const auth = useAuth();
const router = useRouter();

const submit = async () => {
  try {
    await auth.login(email.value, password.value);
    router.push('/'); 
  } catch (err: any) {
    alert('Login failed');
  }
};
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <Card class="w-full max-w-sm  shadow-lg rounded-xl">
      <CardHeader>
        <CardTitle class="text-xl font-semibold text-center">
          Login to your account
        </CardTitle>
        <CardDescription class="text-center">
          Enter your email below to login to your account
        </CardDescription>
      </CardHeader>

      <CardContent>
        <form class="flex flex-col gap-6">
          <div class="flex flex-col gap-2">
            <Label for="email">Email</Label>
            <Input
              id="email"
              type="email"
              placeholder="m@example.com"
              v-model="email"
              required
            />
          </div>

          <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between">
              <Label for="password">Password</Label>
              
            </div>
            <Input id="password" type="password" v-model="password" required />
          </div>
        </form>
      </CardContent>

      <CardFooter class="flex flex-col gap-2">
        <Button type="submit" class="w-full" @click="submit">
          Login
        </Button>
        <Button variant="outline" class="w-full">
          <router-link to="/register">Don't have an account? Register</router-link>
        </Button>
      </CardFooter>
    </Card>
  </div>
</template>



