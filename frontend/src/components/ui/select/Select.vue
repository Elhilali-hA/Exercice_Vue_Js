<script setup lang="ts">
import {  defineEmits } from 'vue'

const props = defineProps<{
  modelValue: string
  class?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>

<template>
  <select
    :value="props.modelValue"
    @change="(e) => emit('update:modelValue', (e.target as HTMLSelectElement).value)"
    :class="['border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500', props.class]"
  >
    <slot />
  </select>
</template>
