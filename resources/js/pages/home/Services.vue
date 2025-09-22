<template>
  <section class="py-16 bg-gray-50" aria-labelledby="services-heading">
    <div class="container mx-auto px-6">
      <h2 id="services-heading" class="text-3xl font-bold text-center mb-12">
        Our Services
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <article
          v-for="service in services"
          :key="service.title"
          class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition"
        >
          <figure class="h-48 w-full">
            <img
              :src="service.image"
              :alt="service.title"
              class="h-full w-full object-cover"
              loading="lazy"
            />
          </figure>
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">{{ service.title }}</h3>
            <p class="text-gray-600 text-sm">{{ service.description }}</p>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref,onMounted } from 'vue';
import { Service } from '../../types';

const props=defineProps<{
  services:Service[];
}>();

onMounted(() => {
  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Service",
    "serviceType": "Lighting and Camera Crew Services",
    "provider": {
      "@type": "Organization",
      "name": "Your Company Name",
      "url": "https://yourdomain.com"
    },
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Our Services",
      "itemListElement": props.services.map(service => ({
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": service.title,
          "description": service.description,
          "image": service.image
        }
      }))
    }
  };

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.innerHTML = JSON.stringify(jsonLd);
  document.head.appendChild(script);
});
</script>

<style scoped>
/* optional hover effect */
img {
  transition: transform 0.4s ease;
}
img:hover {
  transform: scale(1.05);
}
</style>
