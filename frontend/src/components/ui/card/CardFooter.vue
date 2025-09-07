<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const footerClass = computed(() =>
  ["flex items-center px-6 [.border-t]:pt-6", props.class].filter(Boolean).join(" ")
)
</script>

<template>
  <div :class="footerClass" data-slot="card-footer">
    <slot />
  </div>
</template>
