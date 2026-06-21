import { defineStore } from 'pinia';

const STORAGE_KEY = 'rental-cart-v1';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
  }),
  getters: {
    totalItems(state) {
      return state.items.length;
    },
    totalQuantity(state) {
      return state.items.reduce((sum, item) => sum + item.quantity, 0);
    },
    cartSummary(state) {
      return {
        totalItems: state.items.length,
        totalQuantity: state.items.reduce((sum, item) => sum + item.quantity, 0),
      };
    },
  },
  actions: {
    initialize() {
      if (typeof window === 'undefined') {
        return;
      }

      const stored = window.localStorage.getItem(STORAGE_KEY);

      if (stored) {
        try {
          this.items = JSON.parse(stored) || [];
        } catch {
          this.items = [];
        }
      }
    },
    persist() {
      if (typeof window === 'undefined') {
        return;
      }

      window.localStorage.setItem(STORAGE_KEY, JSON.stringify(this.items));
    },
    addItem(payload) {
      const existing = this.items.find((item) => item.item_id === payload.item_id);

      if (existing) {
        existing.quantity += payload.quantity ?? 1;
      } else {
        this.items.push({
          item_id: payload.item_id,
          name: payload.name,
          brand: payload.brand,
          image: payload.image,
          quantity: payload.quantity ?? 1,
          url: payload.url,
        });
      }

      this.persist();
    },
    updateQuantity(itemId, quantity) {
      const existing = this.items.find((item) => item.item_id === itemId);
      if (!existing) {
        return;
      }
      existing.quantity = Math.max(1, quantity);
      this.persist();
    },
    removeItem(itemId) {
      this.items = this.items.filter((item) => item.item_id !== itemId);
      this.persist();
    },
    clearCart() {
      this.items = [];
      this.persist();
    },
  },
});
