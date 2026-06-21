<!-- resources/js/Layouts/AppLayout.vue -->
<template>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
     <Header/>

    <!-- Main content -->
    <main class=" flex-1 bg-gradient-to-t from-accent via-accent to-primary/50">
      <slot     />
    </main>

    <!-- Footer -->
    <Footer/>

  </div>
</template>

<script setup lang="ts">
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { Contact } from '@/types';

const contact = ref<Contact>();

onMounted(async () => {
  const res = await axios.get("/api/contact");
  contact.value = res.data;
});


provide("contact", contact);
</script>

<style scoped>
/* Optional: main content scrollbar styling */
main::-webkit-scrollbar {
  width: 6px;
}
main::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 3px;
}
</style>
