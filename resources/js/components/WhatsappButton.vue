<template>
  <div>
   
    
    <!-- Floating WhatsApp Button -->
    <a
       :href="`https://wa.me/${number}`"
      target="_blank"
      class="fixed bottom-5 right-5 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition"
    >
      <i class="fab fa-whatsapp fa-2x"></i>
    </a>
  </div>
</template>

<script setup lang="ts">
const props=defineProps<
{
    number:String;
}
>()
</script>
