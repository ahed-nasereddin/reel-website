<template>
  <div class="relative h-screen overflow-hidden">
    <!-- Slides -->
    <div 
      v-if="slides.length>0"
      v-for="(slide, index) in slides"
      :key="index"
      class="absolute top-0 left-0 w-full h-full transition-all duration-700"
      :class="{
        'opacity-100 z-20': currentSlide === index,
        'opacity-0 z-10': currentSlide !== index
      }"
      :style="{
        backgroundImage: `linear-gradient(to right, rgba(0,0,0,0.9), rgba(0,0,0,0.6), rgba(0,0,0,0.2)), url(${fixImagePath(slide.image)})`,
        backgroundSize: 'cover',
        backgroundPosition: 'center'
      }"
    >
      <article class="h-full flex flex-col justify-center px-6 md:px-16 text-white">
        <h3 class="text-4xl md:text-6xl font-outfit font-bold mb-4">
          <span v-html="slide.title"></span>
        </h3>
        <p class="text-lg md:text-xl font-ysabeau mb-6">
          {{ slide.subtitle }}
          
        </p>
        <a v-if="slide.link"
          :href="slide.link"
          class="inline-block bg-primary text-white px-6 py-3 rounded-lg uppercase tracking-wider font-bold hover:scale-105 transition-transform"
        >
          {{ slide.cta }}

        </a>
      </article>
    </div>

    <!-- Dots -->
    <div class="absolute bottom-6 left-6 flex gap-2 z-30">
      <button
        v-for="(slide, index) in slides"
        :key="index"
        @click="goToSlide(index)"
        class="w-3 h-3 rounded-full transition-all"
        :class="currentSlide === index ? 'bg-primary scale-125' : 'bg-white/70 hover:bg-white'"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Slider } from '../types';

const props=defineProps<{
  slides:Slider[];
}>();

const currentSlide = ref(0);
let interval = null;

const goToSlide = (index) => {
  currentSlide.value = index;
};

onMounted(() => {
  interval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % props.slides.length;
  }, 4000);
});

onUnmounted(() => {
  clearInterval(interval);
});

const fixImagePath = (path: string) => {
  return `/storage/${path.replace(/\\/g, "/")}`;
};
</script>

<style scoped>
em {
  font-style: normal;
  background: linear-gradient(145deg, #ff2f09, #c24a4e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
