<template>
  <footer class=" bg-gradient-to-b from-secondary to-primary text-accent font-bold border-t-1 border-secondary py-4">
    <div class="max-w-7xl mx-auto px-6 grid items-center justify-center">
      
      <!-- Copyright -->
      <p class="text-sm mb-4 md:mb-0">
        &copy; 2025 My Website. All rights reserved.
      </p>

      <!-- Social Media Icons -->
      <div class="flex justify-center items-center my-2 gap-4">
        <a 
          v-if="contact?.facebook" 
          :href="contact.facebook" 
          target="_blank" 
          class="hover:text-[#14B8B8] transition"
        >
          <i class="fab fa-facebook-f"></i>
        </a>
        <a 
          v-if="contact?.instagram" 
          :href="contact.instagram" 
          target="_blank" 
          class="hover:text-[#14B8B8] transition"
        >
          <i class="fab fa-instagram"></i>
        </a>
      </div>

    </div>
  </footer>
</template>
<script setup lang="ts">
import { Contact } from "@/types";
import axios from "axios";
import { inject, onMounted, ref, Ref } from "vue";
const contact = ref<Contact | null>(null);

const fetchContact = async () => {
  try {
    const res = await axios.get("/api/contact");
    contact.value = res.data.data; //API structure
  } catch (error) {
    console.error("Error fetching contact:", error);
  }
};
onMounted(() => {
  fetchContact();
});
</script>

<style>
@import "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css";
</style>
