<script setup lang="ts">

const props = defineProps<{
  for?: string
  class?: string
}>()
</script>

<template>
  <label
    :for="props.for"
    :class="['text-sm font-medium text-slate-900 ', props.class]"
  >
    <slot />
  </label>
</template>
