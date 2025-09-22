<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Team</h2>
      <p class="text-gray-600 mb-12">
        Meet the passionate professionals behind our success.
      </p>

      <Swiper
        :modules="[Pagination, Autoplay]"
        :slides-per-view="1"
        :space-between="20"
        :loop="true"
        :pagination="{ clickable: true }"
        :autoplay="{ delay: 3000 }"
        :breakpoints="{
          640: { slidesPerView: 2 },
          1024: { slidesPerView: 4 }
        }"
        class="pb-12"
      >
        <SwiperSlide
          v-for="(member, index) in teamMembers"
          :key="index"
          class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6"
        >
          <img
            :src="member.image"
            :alt="member.name"
            class="w-32 h-32 mx-auto rounded-full object-cover mb-4 border-4 border-gray-100"
          />
          <h3 class="text-xl font-semibold text-gray-800">{{ member.name }}</h3>
          <p class="text-indigo-600 font-medium">{{ member.position }}</p>
          <p class="text-gray-600 text-sm mt-3">{{ member.bio }}</p>

         
        </SwiperSlide>
      </Swiper>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import { TeamMember } from "../../types";

const props=defineProps<{
teamMembers:TeamMember[];
}>();
</script>

<style>
@import "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css";
</style>
