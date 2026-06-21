<template>
  <article class="rounded-3xl border border-primary/10 bg-white shadow-sm overflow-hidden transition hover:-translate-y-1 hover:shadow-lg">
    <Link :href="item.url" class="block h-56 overflow-hidden">
      <img
        :src="item.main_image || '/default-project.jpg'"
        :alt="item.title || item.name"
        class="h-full w-full object-cover transition duration-300 ease-in-out hover:scale-105"
      />
    </Link>

    <div class="p-6 space-y-4">
      <div class="space-y-2">
        <Link :href="item.url" class="text-xl font-semibold text-primary hover:text-accent">
          {{ item.title || item.name }}
        </Link>
        <div class="text-sm text-secondary">
          
          <span v-if="item.brand">{{ item.brand.name }}</span>
          <span v-if="item.brand && item.category"> · </span>
          <span v-if="item.category">{{ item.category.name }}</span>
        </div>
      </div>

      <p class="text-sm text-gray-600 line-clamp-3" v-html="item.sub_description || item.description || 'Professional film equipment ready for immediate rental.'"></p>

      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <button
          type="button"
          @click="handleAddToCart"
          class="inline-flex items-center justify-center
          rounded-full bg-primary px-4 py-3 text-white transition 
            hover:bg-accent hover:text-primary hover:border hover:border-primary
            text-sm font-semibold text-white transition "
        >
          Add to cart
        </button>
        <Link
          :href="item.url"
          class=" text-center rounded-full border border-primary px-4 py-2 text-sm font-semibold text-primary transition hover:bg-primary hover:text-white"
        >
          View details
        </Link>
      </div>
    </div>
  </article>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
  item: Record<string, any>;
}>();
import { onMounted } from 'vue';
import { useCart } from '@/composables/useCart';

const { addToCart, initializeCart } = useCart();

onMounted(() => {
  initializeCart();
});

const handleAddToCart = () => {
  addToCart(props.item);
};
</script>
