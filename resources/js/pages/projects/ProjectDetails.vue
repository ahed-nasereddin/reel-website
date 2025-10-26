<template>
  <section class="py-16 bg-gradient-to-t from-primary/30 via-accent to-primary/30">
    <div v-if="project" class="container mx-auto px-6">
      <!-- Back button -->
      <button 
        @click="$router.back()" 
        class="mb-6 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
      >
        ← Back
      </button>

      <!-- Project card -->
      <div class="bg-gray-50 shadow-lg rounded-2xl overflow-hidden">
        <img :src="project.main_image" :alt="project.name + ' lighting and camera project'" class="w-full h-64 object-cover" />
        <div class="p-6">
          <h2 class="text-3xl font-bold mb-4">{{ project.name }}</h2>
          <p class="text-gray-600 mb-2">Client: <span class="font-semibold">{{ project.client }}</span></p>
          <p v-html="project.description" class="text-gray-700 mb-6"></p>

          <!-- Services -->
          <div v-if="project.services.length" class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Services Provided:</h3>
            <ul class="list-disc list-inside text-gray-600">
              <li v-for="(service, i) in project.services" :key="i">{{ service }}</li>
            </ul>
          </div>

          <!-- Images Gallery Slider -->
          <div v-if="project.images.length" class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Project Gallery</h3>
            <Swiper
              :modules="[Navigation, Pagination]"
              navigation
              pagination
              space-between="10"
              slides-per-view="3"
              class="w-full"
            >
              <SwiperSlide v-for="(img, i) in project.images" :key="i">
                <img
                  :src="img"
                  class="w-full h-48 object-cover rounded-lg cursor-pointer"
                  @click="openLightbox(i)"
                />
              </SwiperSlide>
            </Swiper>
            <!-- Lightbox -->
            <VueEasyLightbox
              :visible="showLightbox"
              :imgs="project.images"
              :index="lightboxIndex"
              @hide="showLightbox = false"
            />
          </div>

          <!-- Videos Gallery Slider -->
          <div v-if="project.videos.length">
            <h3 class="text-lg font-semibold mb-2">Project Videos</h3>
            <Swiper
              :modules="[Navigation, Pagination]"
              navigation
              pagination
              space-between="10"
              slides-per-view="1"
              class="w-full h-96 rounded-lg overflow-hidden"
            >
              <SwiperSlide v-for="(video, i) in project.videos" :key="i">
                <video class="w-full h-96 rounded-lg" controls>
                  <source :src="video" type="video/mp4" />
                </video>
              </SwiperSlide>
            </Swiper>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="flex justify-center items-center text-red-500 font-semibold">
      {{ responseError }}
    </div>
  </section>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import { useHead } from "@vueuse/head";

// Swiper
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// Lightbox
import VueEasyLightbox from "vue-easy-lightbox";
import { Project } from "@/types";

// Types


const route = useRoute();
const responseError = ref<string>("");
const project = ref<Project | null>(null);

// Lightbox
const showLightbox = ref(false);
const lightboxIndex = ref(0);
function openLightbox(index: number) {
  lightboxIndex.value = index;
  showLightbox.value = true;
}

onMounted(async () => {
  try {
    const response = await axios.get(`/api/projects/${route.params.slug}`);
    project.value = response.data.data;
  } catch (error: any) {
    responseError.value = error.message || "Failed to load project";
  }
});


// 🔹 when project loads → set SEO meta tags
watch(project, (p) => {
  if (!p) return;
  useHead({
    title: `${p.name} | Lighting & Camera Services`,
    meta: [
      { name: "description", content: p.description?.substring(0, 160) || "" },
      { property: "og:title", content: p.name },
      { property: "og:description", content: p.description?.substring(0, 160) || "" },
      { property: "og:image", content: p.main_image || "/default-project.jpg" },
      { property: "og:type", content: "article" },
      { property: "og:url", content: window.location.href },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:title", content: p.name },
      { name: "twitter:description", content: p.description?.substring(0, 160) || "" },
      { name: "twitter:image", content: p.main_image || "/default-project.jpg" },
    ],
  });
   });
</script>
