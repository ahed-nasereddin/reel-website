<template>
  <section class="py-12 mt-20 bg-gray-50">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-8">
      <!-- Map -->
      <div class="w-full h-80 rounded-2xl overflow-hidden shadow" v-if="contact">
        <iframe
          class="w-full h-full"
          :src="`https://www.google.com/maps?q=${contact.coordinates.latitude},${contact.coordinates.longitude}&hl=es;z=14&output=embed`"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>

      <!-- Contact Info -->
      <div class="flex flex-col justify-center space-y-6" v-if="contact">
        <!-- Address -->
        <div v-if="contact.address">
          <h3 class="text-xl font-semibold mb-1">Address</h3>
          <p class="text-gray-600">{{ contact.address }}</p>
        </div>

        <!-- Phone -->
        <div v-if="contact.mobile_number">
          <h3 class="text-xl font-semibold mb-1">Phone</h3>
          <p class="text-gray-600">
            <a :href="`tel:${contact.mobile_number}`" class="hover:underline">
              {{ contact.mobile_number }}
            </a>
          </p>
        </div>

        <!-- WhatsApp -->
        <div v-if="contact.whatsapp">
          <h3 class="text-xl font-semibold mb-1">WhatsApp</h3>
          <p class="text-gray-600">
            <a
              :href="`https://wa.me/${contact.whatsapp}`"
              target="_blank"
              class="hover:underline text-green-600"
            >
              Chat on WhatsApp
            </a>
          </p>
        </div>

        <!-- Social Media -->
        <div>
          <h3 class="text-xl font-semibold mb-2">Follow Us</h3>
          <div class="flex space-x-4">
            <a
              v-if="contact.facebook"
              :href="contact.facebook"
              target="_blank"
              class="text-blue-600 hover:opacity-80"
            >
              <i class="fab fa-facebook fa-lg"></i>
            </a>
            <a
              v-if="contact.instagram"
              :href="contact.instagram"
              target="_blank"
              class="text-pink-500 hover:opacity-80"
            >
              <i class="fab fa-instagram fa-lg"></i>
            </a>
         
          </div>
        </div>
      </div>

      <!-- Loading / fallback -->
      <p v-else class="text-gray-500 col-span-2">Loading contact info...</p>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import type { Contact } from "@/types";

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

<style scoped>
/* تأكد أنك مركب Font Awesome أو أي أيقونات تريدها */
</style>
