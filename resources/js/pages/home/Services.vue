<template>
<section class="py-16 bg-gradient-to-t from-white via-primary/5 to-white" aria-labelledby="services-heading">
  <div class="container mx-auto px-6">
    <!-- Section Title -->
    <h2 id="services-heading" class="text-3xl md:text-4xl font-bold text-center text-primary mb-12">
      Our Services
    </h2>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <article
        v-for="service in services"
        :key="service.title"
        class="bg-white border border-primary/20 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transform hover:-translate-y-2 transition duration-300"
      >
        <!-- Image -->
        <figure class="h-48 w-full overflow-hidden rounded-t-2xl">
          <img
            :src="service.image"
            :alt="service.title"
            class="h-full w-full object-cover hover:scale-105 transition-transform duration-500"
            loading="lazy"
          />
        </figure>

        <!-- Content -->
        <div class="p-6 text-center">
          <h3 class="text-2xl font-bold text-primary mb-2">{{ service.title }}</h3>
          <p class="text-secondary text-sm leading-relaxed">
            {{ service.description }}
          </p>
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
