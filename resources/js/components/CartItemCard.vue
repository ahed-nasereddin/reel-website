<template>
  <div class="grid gap-4 rounded-3xl border border-primary/10 bg-white p-4 shadow-sm sm:grid-cols-[auto_1fr_auto] sm:items-center">
    <img :src="item.image || '/default-project.jpg'" :alt="item.name" class="h-20 w-20 rounded-2xl object-cover" />

    <div class="space-y-2">
      <div class="flex items-center justify-between gap-3">
        <div>
          <p class="font-semibold text-primary">{{ item.name }}</p>
          <p class="text-sm text-secondary">{{ item.brand || 'Equipment' }}</p>
        </div>
        <button type="button" @click="$emit('remove', item.item_id)" class="text-sm text-red-600 hover:text-red-800">Remove</button>
      </div>

      <div class="flex items-center gap-2">
        <button
          type="button"
          class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-primary text-primary transition hover:bg-primary hover:text-white"
          @click="$emit('decrement', item.item_id)"
        >
          -
        </button>
        <span class="min-w-[2rem] text-center text-lg font-semibold">{{ item.quantity }}</span>
        <button
          type="button"
          class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-primary text-primary transition hover:bg-primary hover:text-white"
          @click="$emit('increment', item.item_id)"
        >
          +
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
});
</script>
