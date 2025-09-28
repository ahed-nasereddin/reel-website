<template>
  <section class="py-16 bg-accent border-b-1">
    <div class="mx-auto text-center">
      <!-- Section Title -->
      <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-10">
        What Our Clients Say
      </h2>

      <!-- Swiper Slider -->
      <swiper
        :modules="[Pagination, Autoplay, EffectCoverflow]"
        :pagination="{ clickable: true }"
        :autoplay="{ delay: 4000 }"
        :loop="true"
        :slides-per-view="3"
        :centered-slides="false"
        :space-between="30"
        :coverflow-effect="{
          rotate: 0,
          stretch: 200,
          depth: 400,
          modifier: 1,
          slideShadows: true
        }"
        class="w-full"
      >
        <swiper-slide v-for="(testimonial, i) in testimonials" :key="i" class="max-w-md px-4">
          <div
            class="shadow-lg border border-primary rounded-2xl p-0 flex flex-col items-center text-center transition-transform transform hover:-translate-y-2 hover:shadow-xl">
            <p class="text-secondary/70 font-bold bg-primary/10 min-h-20 rounded-t-2xl italic mb-1 leading-relaxed p-4 w-full"
              v-html="testimonial.content"></p>

            <div>
              <h3 class="mt-4 text-xl w-auto py-1 px-2 text-primary w rounded-lg font-bold">
                {{ testimonial.name }}
              </h3>
              <p class="text-secondary font-semibold text-md">
                {{ testimonial.position }}
                <span v-if="testimonial.company">
                  • {{ testimonial.company }}</span>
              </p>
            </div>
          </div>
        </swiper-slide>
              <div class="custom-pagination mt-12"></div>

      </swiper>

      <!-- Add Testimonial Button -->
      <div class="mt-8 flex justify-center">
        <button
          class="border border-primary text-primary font-semibold px-8 py-3 rounded-2xl hover:bg-primary hover:text-accent transition duration-300"
          @click="showModal = true">
          Add Testimonial
        </button>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 px-4">
        <div class="bg-black text-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
          <button @click="showModal = false"
            class="absolute top-3 right-3 text-primary hover:text-white text-lg font-bold">
            &times;
          </button>

          <h2 class="text-2xl font-semibold mb-4 text-primary text-center">
            Add Testimonial
          </h2>

          <form @submit.prevent="submitTestimonial" class="space-y-4">
            <input v-model="newTestimonial.name" placeholder="Name"
              class="w-full px-4 py-2 border border-primary rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-primary"
              required />
            <input v-model="newTestimonial.position" placeholder="Position"
              class="w-full px-4 py-2 border border-primary rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-primary" />
            <input v-model="newTestimonial.company" placeholder="Company"
              class="w-full px-4 py-2 border border-primary rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-primary" />
            <textarea v-model="newTestimonial.content" placeholder="Testimonial" rows="4"
              class="w-full px-4 py-2 border border-primary rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-primary resize-none"
              required></textarea>

            <div class="flex justify-end gap-2">
              <button type="submit"
                class="bg-primary text-black px-4 py-2 rounded-lg hover:bg-white hover:text-black transition">
                Submit
              </button>
              <button type="button" @click="showModal = false"
                class="bg-white text-black px-4 py-2 rounded-lg hover:bg-primary hover:text-black transition">
                Cancel
              </button>
            </div>
          </form>
        </div>
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

import { ref, onMounted } from "vue";
import axios from "axios";
import type { Testimonial } from "@/types";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
const testimonials = ref<Testimonial[]>([]);
const showModal = ref(false);

const breakpoints = {
  0: {
    slidesPerView: 1.1, // mobile: show ~1 slide
    centeredSlides: false,
  },
  640: {
    slidesPerView: "auto", // small tablets
    centeredSlides: false,
  },
  768: {
    slidesPerView: "auto", // desktop
    centeredSlides: true,
  },
};

const fetchTestimonials = async () => {
  const res = await axios.get("/api/testimonials");
  console.log(res);
  testimonials.value = res.data;
};
const newTestimonial = ref<Testimonial>({
  id: 0,
  name: "",
  position: "",
  company: "",
  content: "",
});

const submitTestimonial = async () => {
  const formData = new FormData();
  formData.append("name", newTestimonial.value.name);
  formData.append("position", newTestimonial.value.position || "");
  formData.append("company", newTestimonial.value.company || "");
  formData.append("content", newTestimonial.value.content);

  console.log("submit", formData);
  await axios.post("/api/testimonials", formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });

  showModal.value = false;
  // ✅ Show success toast
  toast.success("Thank you! Your testimonial was submitted successfully ", {
    autoClose: 3000,
    position: "top-right",
    theme: "colored",
  });
  fetchTestimonials();
};

onMounted(fetchTestimonials);

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
      reviewBody: t.content,
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