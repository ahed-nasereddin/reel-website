<template>
  <section class="py-16 bg-accent border-b-1">
    <div class="mx-auto text-center">
      <!-- Section Title -->
      <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-10">
        What Our Clients Say  
      </h2>

      <!-- Swiper Slider -->
     <swiper
      class="swiper"
        :modules="[Pagination, Autoplay]"

  :autoplay="{ delay: 4000 }"
  :loop="true"
      :space-between="30"
    slides-per-view="auto"
    :centered-slides="false"
    :pagination="{ clickable: true }"
    >

   
       
        <swiper-slide v-for="(testimonial, i) in testimonials" :key="i" class="max-w-md px-4">
          <div class="shadow-lg rounded-2xl p-6 bg-white flex flex-col justify-between h-full transition-transform hover:-translate-y-2 hover:shadow-xl">
            <div>
              <p class="text-slate-700 text-base leading-relaxed mb-4" v-html="testimonial.message"></p>
            </div>

            <div class="mt-4 flex items-center justify-between">
              <div>
                <h3 class="mt-0 text-lg font-semibold text-slate-900">{{ testimonial.name }}</h3>
              </div>

              <div class="flex items-center gap-1">
                <svg v-for="n in 5" :key="n" :class="n <= (testimonial.rating ?? 5) ? 'w-4 h-4 text-yellow-400' : 'w-4 h-4 text-slate-200'" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.371 2.448a1 1 0 00-.364 1.118l1.286 3.95c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.371 2.448c-.784.57-1.839-.197-1.54-1.118l1.286-3.95a1 1 0 00-.364-1.118L2.64 9.377c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.95z"/>
                </svg>
              </div>
            </div>
          </div>
        </swiper-slide>
         <div class="custom-pagination mt-12"></div>


      </swiper>

   

      
    </div>
  </section>
</template>

<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Autoplay, EffectCoverflow } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/effect-coverflow";
import { defineComponent } from 'vue'
  import 'swiper/css'
  import 'swiper/css/pagination'

import { ref, onMounted, computed } from "vue";
import axios from "axios";
import type { Testimonial } from "@/types";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps<{
  testimonials?: Testimonial[];
}>();

const testimonials = computed(() => props.testimonials ?? []);
defineComponent({
    name: 'swiper-example-3d-coverflow',
    title: '3D Coverflow effect',
    url: import.meta.url,
    components: {
      Swiper,
      SwiperSlide
    },
    setup() {
      return {
        modules: [Pagination,Autoplay, EffectCoverflow]
      }
    }
  })






onMounted(() => {
  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Product", // or Service if you want
    name: "Lighting and Camera Crew Services",
    aggregateRating: {
      "@type": "AggregateRating",
      ratingValue: "4.8",
      reviewCount: "25",
    },
    review: testimonials.value.map((t) => ({
      "@type": "Review",
      reviewBody: t.message || t.content,
      author: {
        "@type": "Person",
        name: t.name,
      },
      reviewRating: undefined,
    })),
  };

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.innerHTML = JSON.stringify(jsonLd);
  document.head.appendChild(script);
});
</script>
<style>
/* Make bullets below the slides and spaced */

</style>