import axios from 'axios';
import { storeToRefs } from 'pinia';
import { useCartStore } from '@/stores/cartStore';
import { toast } from 'vue3-toastify';

export function useCart() {
  const cartStore = useCartStore();
  const { items, totalItems, totalQuantity, cartSummary } = storeToRefs(cartStore);

  const initializeCart = () => {
    cartStore.initialize();
  };

  const addToCart = async (item) => {
    const payload = {
      item_id: item.id,
      name: item.title || item.name,
      brand: item.brand?.name || item.brand || null,
      image: item.main_image || null,
      url: item.url || null,
      quantity: 1,
    };

    cartStore.addItem(payload);

    try {
      await axios.post('/api/cart/add', {
        item_id: payload.item_id,
        quantity: payload.quantity,
      });
    } catch (error) {
      console.warn('Cart API add failed', error);
    }

    toast.success('Added to cart');
  };

  const updateQuantity = async (itemId, quantity) => {
    cartStore.updateQuantity(itemId, quantity);

    try {
      await axios.post('/api/cart/update', {
        item_id: itemId,
        quantity,
      });
    } catch (error) {
      console.warn('Cart API update failed', error);
    }
  };

  const removeFromCart = async (itemId) => {
    cartStore.removeItem(itemId);

    try {
      await axios.post('/api/cart/remove', {
        item_id: itemId,
      });
    } catch (error) {
      console.warn('Cart API remove failed', error);
    }

    toast.info('Removed from cart');
  };

  const clearCart = () => {
    cartStore.clearCart();
  };

  return {
    cartStore,
    items,
    totalItems,
    totalQuantity,
    cartSummary,
    initializeCart,
    addToCart,
    updateQuantity,
    removeFromCart,
    clearCart,
  };
}
