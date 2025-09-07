<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { computed } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()

const actionClass = computed(() =>
  [
    "col-start-2 row-span-2 row-start-1 self-start justify-self-end",
    props.class,
  ]
    .filter(Boolean)
    .join(" ")
)
</script>

<template>
  <div :class="actionClass" data-slot="card-action">
    <slot />
  </div>
</template>
