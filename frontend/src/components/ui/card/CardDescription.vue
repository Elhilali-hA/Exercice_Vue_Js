<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const descClass = computed(() =>
  ["text-muted-foreground text-sm", props.class].filter(Boolean).join(" ")
)
</script>

<template>
  <div :class="descClass" data-slot="card-description">
    <slot />
  </div>
</template>
