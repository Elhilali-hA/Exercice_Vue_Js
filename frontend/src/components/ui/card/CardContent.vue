<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const contentClass = computed(() =>
  ["px-6", props.class].filter(Boolean).join(" ")
)
</script>

<template>
  <div :class="contentClass" data-slot="card-content">
    <slot />
  </div>
</template>
