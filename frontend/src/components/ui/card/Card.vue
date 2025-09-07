<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const cardClass = computed(() =>
  [
    "bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm",
    props.class,
  ]
    .filter(Boolean)
    .join(" ")
)
</script>

<template>
  <div :class="cardClass" data-slot="card">
    <slot />
  </div>
</template>
