<template>
  <button
    type="button"
    class="relative inline-flex h-12 w-12 items-center justify-center rounded-full border border-primary bg-white text-primary shadow-sm transition hover:bg-primary hover:text-white"
    @click="$emit('toggle')"
    aria-label="Open cart"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7H18m-9 0a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z" />
    </svg>
    <span v-if="count > 0" class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1.5 text-xs font-bold text-white">
      {{ count }}
    </span>
  </button>
</template>

<script setup>
const props = defineProps({
  count: {
    type: Number,
    default: 0,
  },
});
</script>
