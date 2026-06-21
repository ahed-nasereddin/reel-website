<template>
  <Head>
    <title>Quotation Request | ReelQuip Films</title>
    <meta name="description" content="Create a rental equipment quotation for your production needs." />
    <meta name="robots" content="noindex" />
  </Head>

  <section class="py-16 mt-14">
    <div class="mx-auto max-w-6xl px-6">
      <div class="mb-10 rounded-3xl border border-primary/10 bg-white p-8 shadow-sm">
        <h1 class="text-3xl font-bold text-primary">Create a Quotation</h1>
        <p class="mt-2 text-secondary">Review your cart and submit your rental details.</p>
      </div>

      <div class="grid gap-8 xl:grid-cols-[1.3fr_0.7fr]">
        <form @submit.prevent="handleSubmit" class="order-2 xl:order-1 space-y-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
          <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
              <h2 class="text-xl font-semibold text-slate-900">Quotation Details</h2>
              <p class="mt-2 text-sm text-slate-500">Enter your contact and rental details below.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <input v-model="form.name" type="text" placeholder="Your Name" required class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model="form.company_name" type="text" placeholder="Company Name" class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model="form.email" type="email" placeholder="Email" required class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model="form.mobile" type="tel" placeholder="Mobile" required class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model.number="form.no_days" type="number" min="1" placeholder="Number of Days" required class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model="form.pickup_date" type="datetime-local" placeholder="Pickup Date" required class="border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
              <input v-model="form.location" type="text" placeholder="Location" required class="col-span-1 md:col-span-2 border rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-sky-500" />
            </div>
          </div>

          <div class="space-y-4">
            <label class="block text-lg font-semibold text-slate-900">Special Requests</label>
            <textarea v-model="form.notes" rows="5" placeholder="Add any notes or special instructions" class="w-full resize-none rounded-2xl border border-slate-200 p-4 text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
          </div>

          <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-slate-500">
              You can update your cart items on the right before submitting.
            </div>
            <button :disabled="loading || items.length === 0" type="submit" 
            class="w-full rounded-full bg-primary px-4 py-3 text-white transition 
            hover:bg-accent hover:text-primary hover:border hover:border-primary disabled:cursor-not-allowed disabled:opacity-50">
              <span v-if="loading">Submitting...</span>
              <span v-else>Submit Quotation</span>
            </button>
          </div>

          <div v-if="error" class="rounded-2xl bg-red-50 p-4 text-sm text-red-700">{{ error }}</div>
          <div v-if="success" class="rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-700">{{ success }}</div>
        </form>

        <section class="order-1 xl:order-2 space-y-6">
          <div class="rounded-3xl border border-primary/10 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
              <div>
                <p class="text-sm uppercase tracking-[0.3em] text-secondary">Current cart</p>
                <h2 class="text-2xl font-semibold text-primary">{{ cartSummary.totalItems }} products</h2>
              </div>
              <p class="text-sm text-secondary">{{ cartSummary.totalQuantity }} total quantity</p>
            </div>
          </div>

          <div v-if="items.length === 0" class="rounded-3xl border border-primary/10 bg-slate-50 p-6 text-center text-secondary">
            Your cart is empty. Browse equipment and add items to build a quotation.
          </div>

          <div class="space-y-4" v-else>
            <CartItemCard
              v-for="item in items"
              :key="item.item_id"
              :item="item"
              @increment="increment(item.item_id)"
              @decrement="decrement(item.item_id)"
              @remove="removeItem"
            />
          </div>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import CartItemCard from '@/components/CartItemCard.vue';
import { useQuotation } from '@/composables/useQuotation';
import { useCart } from '@/composables/useCart';

defineOptions({ layout: AppLayout });

const { initializeCart } = useCart();
const { items, cartSummary, submitQuotation, loading, error, success, updateQuantity, removeFromCart } = useQuotation();

const form = reactive({
  name: '',
  company_name: '',
  email: '',
  mobile: '',
  no_days: 1,
  pickup_date: '',
  location: '',
  notes: '',
});

const handleSubmit = async () => {
  const payload = {
    name: form.name,
    company_name: form.company_name,
    email: form.email,
    mobile: form.mobile,
    no_days: form.no_days,
    pickup_date: form.pickup_date,
    location: form.location,
    notes: form.notes,
    items: items.value.map((item) => ({
      item_id: item.item_id,
      quantity: item.quantity,
    })),
  };

  await submitQuotation(payload);
};

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

onMounted(() => {
  initializeCart();
});
</script>

<style scoped>
.primary-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.9rem 1.75rem;
  border-radius: 9999px;
  background-color: #0f4ad8;
  color: #ffffff;
  font-weight: 600;
  transition: background-color 0.2s ease, transform 0.2s ease;
}

.primary-btn:hover,
.primary-btn:focus {
  background-color: #0d3ea8;
  color: #ffffff;
  transform: translateY(-1px);
}

.primary-btn:active {
  background-color: #0c39a1;
}

.primary-btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

button:hover {
  cursor: pointer;
}
</style>
