<template>
  <!-- Head meta -->
    <Head>
      <title>Contact Us | ReelQuip Films</title>
      <meta
        name="description"
        content="Get in touch with ReelQuip Films for professional lighting and camera services."
      />
      <!-- Open Graph -->
      <meta property="og:title" content="Contact Us | ReelQuip Films" />
      <meta
        property="og:description"
        content="Get in touch with ReelQuip Films for professional lighting and camera services."
      />
      <meta property="og:type" content="website" />
      <meta property="og:url" :content="location" />
      <meta property="og:image" content="/default-contact.jpg" />
      <!-- Twitter -->
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content="Contact Us | ReelQuip Films" />
      <meta
        name="twitter:description"
        content="Get in touch with ReelQuip Films for professional lighting and camera services."
      />
      <meta name="twitter:image" content="/default-contact.jpg" />
    </Head>
  <section class="py-12 mt-20 bg-gray-50">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-8">
      <!-- Map -->
      <div class="w-full h-80 rounded-2xl overflow-hidden shadow" v-if="contact">
        <iframe
          class="w-full h-full"
          :src="`https://www.google.com/maps?q=${contact.coordinates.latitude},${contact.coordinates.longitude}&hl=es;z=14&output=embed`"
          allowfullscreen
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>

      <!-- Contact Info -->
      <div class="flex flex-col justify-center space-y-6" v-if="contact">
        <div v-if="contact.address">
          <h3 class="text-xl font-semibold mb-1">Address</h3>
          <p class="text-gray-600">{{ contact.address }}</p>
        </div>

        <div v-if="contact.mobile_number">
          <h3 class="text-xl font-semibold mb-1">Phone</h3>
          <p class="text-gray-600">
            <a :href="`tel:${contact.mobile_number}`" class="hover:underline">
              {{ contact.mobile_number }}
            </a>
          </p>
        </div>

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

      
    </div>
  </section>
</template>

<script setup lang="ts">
import type { Contact } from '@/types';
import { Head } from '@inertiajs/vue3'

import AppLayout from '@/layouts/AppLayout.vue';
defineOptions({ layout: AppLayout });
const location=window.location.href
const props = defineProps<{
  contact: Contact | null;
}>();

const contact = props.contact;
</script>
