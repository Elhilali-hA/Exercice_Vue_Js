<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const headerClass = computed(() =>
  [
    "@container/card-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 has-data-[slot=card-action]:grid-cols-[1fr_auto] [.border-b]:pb-6",
    props.class,
  ]
    .filter(Boolean)
    .join(" ")
)
</script>

<template>
  <div :class="headerClass" data-slot="card-header">
    <slot />
  </div>
</template>
