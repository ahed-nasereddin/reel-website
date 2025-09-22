<template>
  <section class="py-16 bg-gray-50">
    <div class=" mx-auto text-center">
      <h2 class="text-3xl font-bold mb-10">Testimonials</h2>

      <swiper :modules="[Pagination, Autoplay, EffectCoverflow]" :pagination="{ clickable: true }"
        :autoplay="{ delay: 3000 }" :loop="true" 
        
        :slides-per-view="'auto'" :effect="'coverflow'"
        :coverflow-effect="{
          rotate: 0,
          stretch: 0,
          depth: 200,
          modifier: 2,
          slideShadows: false
        }" class="max-w-4xl w-4xl mx-auto">
        <swiper-slide v-for="(testimonial, i) in testimonials" :key="i" class="max-w-md">
        <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center text-center transition-transform transform hover:-translate-y-1 hover:shadow-xl">
  
          <p v-html="testimonial.content"  class="text-gray-700 italic mb-4 leading-relaxed">
            
          </p>

          
          <h3 class="mt-4 text-lg font-semibold text-gray-900">
            {{ testimonial.name }}
          </h3>

          
          <p class="text-sm text-gray-500">
            {{ testimonial.position }} 
            <span v-if="testimonial.company"> • {{ testimonial.company }}</span>
          </p>
        </div>

        </swiper-slide>
      </swiper>
    </div>
    <div class="mt-4 flex justify-center items-center">
      <button class="bg-primary p-2 hover:scale-105 text-white rounded hover:border-white border-1"
        @click="showModal = true">Add Testimonial</button>

    </div>

    <div v-if="showModal" class="fixed inset-0 bg-black/90  flex items-center justify-center z-50">

      <div class="bg-white rounded-2xl shadow-lg w-11/12 max-w-md p-6 relative">


        <button @click="showModal = false"
          class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg font-bold">
          &times;
        </button>


        <h2 class="text-2xl font-semibold mb-4 text-center">Add Testimonial</h2>


        <form @submit.prevent="submitTestimonial" class="space-y-4">
          <input v-model="newTestimonial.name" placeholder="Name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
            required />
          <input v-model="newTestimonial.position" placeholder="Position"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" />
          <input v-model="newTestimonial.company" placeholder="Company"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" />
          <textarea v-model="newTestimonial.content" placeholder="Testimonial" rows="4"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none resize-none"
            required></textarea>


          <div class="flex justify-end gap-2">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
              Submit
            </button>
            <button type="button" @click="showModal = false"
              class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

</template>

<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Autoplay, EffectCoverflow } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/effect-coverflow";

import { ref, onMounted } from 'vue';
import axios from 'axios';
import type { Testimonial } from '@/types';

const testimonials = ref < Testimonial[] > ([]);
const showModal = ref(false);

const breakpoints = {
  0: {
    slidesPerView: 1.1,     // mobile: show ~1 slide
    centeredSlides: false
  },
  640: {
    slidesPerView: 'auto',  // small tablets
    centeredSlides: false
  },
  768: {
    slidesPerView: 'auto',  // desktop
    centeredSlides: true
  }
};

const fetchTestimonials = async () => {
  const res = await axios.get('/api/testimonials');
  console.log(res);
  testimonials.value = res.data;
};
const newTestimonial = ref < Testimonial > ({
  id: 0,
  name: '',
  position: '',
  company: '',
  content: '',
});

const submitTestimonial = async () => {
  const formData = new FormData();
  formData.append('name', newTestimonial.value.name);
  formData.append('position', newTestimonial.value.position || '');
  formData.append('company', newTestimonial.value.company || '');
  formData.append('content', newTestimonial.value.content);

   console.log('submit',formData);
  await axios.post('/api/testimonials', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });

  showModal.value = false;
  fetchTestimonials();
};

onMounted(fetchTestimonials);


onMounted(() => {
  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Product", // or Service if you want
    "name": "Lighting and Camera Crew Services",
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.8",
      "reviewCount": "25"
    },
    "review": testimonials.value.map(t => ({
      "@type": "Review",
      "reviewBody": t.content,
      "author": {
        "@type": "Person",
        "name": t.name
      },
      "reviewRating":  undefined
    }))
  };

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.innerHTML = JSON.stringify(jsonLd);
  document.head.appendChild(script);
});

</script>
