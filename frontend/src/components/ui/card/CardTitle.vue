<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const titleClass = computed(() =>
  ["leading-none font-semibold", props.class].filter(Boolean).join(" ")
)
</script>

<template>
  <div :class="titleClass" data-slot="card-title">
    <slot />
  </div>
</template>
