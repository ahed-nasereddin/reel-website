<template>
  <transition name="fade-slide">
    <div v-if="open" class="fixed inset-0 z-50 flex items-end justify-end bg-black/30 p-4 sm:items-center sm:p-6">
      <div class="relative w-full max-w-md overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-900/5 sm:h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4">
          <div>
            <h2 class="text-xl font-semibold text-primary">Your Cart</h2>
            <p class="text-sm text-secondary">{{ cartSummary.totalQuantity }} items in {{ cartSummary.totalItems }} products</p>
          </div>
          <button type="button" @click="$emit('close')" class="text-secondary hover:text-primary">Close</button>
        </div>

        <div class="space-y-4 overflow-y-auto p-4" style="max-height: calc(100vh - 12rem)">
          <div v-if="items.length === 0" class="rounded-3xl border border-primary/10 bg-slate-50 p-8 text-center text-secondary">
            Your cart is empty. Add equipment from the catalog.
          </div>

          <CartItemCard
            v-for="item in items"
            :key="item.item_id"
            :item="item"
            @increment="increment(item.item_id)"
            @decrement="decrement(item.item_id)"
            @remove="removeItem"
          />
        </div>

        <div class="border-t border-slate-200 p-4">
          <div class="mb-4 flex items-center justify-between text-sm text-secondary">
            <span>Total products</span>
            <span>{{ cartSummary.totalItems }}</span>
          </div>
          <div class="mb-4 flex items-center justify-between text-sm text-secondary">
            <span>Total quantity</span>
            <span>{{ cartSummary.totalQuantity }}</span>
          </div>

          <button
            type="button"
            :disabled="items.length === 0"
            @click="gotoQuotation"
            class="w-full rounded-full bg-primary px-4 py-3 text-white transition 
            hover:bg-accent hover:text-primary hover:border hover:border-primary disabled:cursor-not-allowed disabled:opacity-50"
          >
            Create Quotation
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import CartItemCard from '@/components/CartItemCard.vue';
import { computed } from 'vue';
import { useCart } from '@/composables/useCart';

const props = defineProps({
  open: {
    type: Boolean,
    default: false,
  },
});
const emits = defineEmits(['close']);

const { items, cartSummary, updateQuantity, removeFromCart } = useCart();
const increment = (itemId) => {
  const item = items.value.find((entry) => entry.item_id === itemId);
  if (!item) return;
  updateQuantity(itemId, item.quantity + 1);
};

const decrement = (itemId) => {
  const item = items.value.find((entry) => entry.item_id === itemId);
  if (!item || item.quantity <= 1) return;
  updateQuantity(itemId, item.quantity - 1);
};

const removeItem = (itemId) => {
  removeFromCart(itemId);
};

const gotoQuotation = () => {
  emits('close');
  router.visit('/Quotation');
};
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(1rem);
}
.fade-slide-enter-to,
.fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>
