import axios from 'axios';
import { ref } from 'vue';
import { useCart } from '@/composables/useCart';

export function useQuotation() {
  const { items, clearCart, updateQuantity, removeFromCart, cartSummary } = useCart();
  const loading = ref(false);
  const error = ref(null);
  const success = ref(null);

  const submitQuotation = async (payload) => {
    loading.value = true;
    error.value = null;
    success.value = null;

    try {
      await axios.post('/api/quotation/create', payload);
      success.value = 'Quotation submitted successfully. Thank you!';
      clearCart();
    } catch (err) {
      error.value = err.response?.data?.message || 'Unable to submit quotation.';
    } finally {
      loading.value = false;
    }
  };

  return {
    items,
    cartSummary,
    loading,
    error,
    success,
    submitQuotation,
    updateQuantity,
    removeFromCart,
  };
}
