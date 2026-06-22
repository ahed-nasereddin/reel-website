<template>
  <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-12 text-center">
        <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Equipment Categories</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Browse our comprehensive collection of professional filming equipment organized by category
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="i in 4" :key="`skeleton-${i}`" class="animate-pulse">
          <div class="bg-slate-200 rounded-2xl h-64 mb-4"></div>
          <div class="bg-slate-200 h-6 rounded w-3/4 mb-2"></div>
          <div class="bg-slate-200 h-4 rounded w-full mb-4"></div>
          <div class="space-y-2">
            <div class="bg-slate-200 h-8 rounded w-1/2"></div>
            <div class="bg-slate-200 h-8 rounded w-1/3"></div>
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <p class="text-lg text-red-600 mb-4">{{ error }}</p>
        <button
          @click="fetchCategories"
          class="inline-flex items-center gap-2 px-6 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition"
        >
          Try Again
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="categories.length === 0" class="text-center py-12">
        <p class="text-lg text-gray-600">No categories available at the moment.</p>
      </div>

      <!-- Categories Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="mainCategory in categories"
          :key="mainCategory.id"
          class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-primary/5"
        >
        
          <!-- Main Category Header -->
          <div class="p-6 border-b border-slate-100">
            <!-- Icon -->
            <div class="mb-4">
             
              <div v-if="mainCategory.icon" class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center">
                <img
                  :src="`/storage/${mainCategory.icon}`"
                  :alt="mainCategory.name"
                  class="w-10 h-10 object-contain"
                />
              </div>
              <div v-else class="w-16 h-16 bg-slate-200 rounded-xl"></div>
            </div>

            <!-- Title & Description -->
            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition">
              {{ mainCategory.name }}
            </h3>
            <p class="text-sm text-gray-600 line-clamp-2 mb-4" v-html=" mainCategory.description || `Explore our ${mainCategory.name} equipment`">
             
            </p>

            <!-- View All Button -->
            <Link
              :href="`/equipment/${mainCategory.slug}`"
              class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary/80 transition"
            >
              View All
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </Link>
          </div>

          <!-- Sub Categories Grid -->
          <div v-if="mainCategory.sub_categories && mainCategory.sub_categories.length > 0" class="p-4">
            <div class="grid grid-cols-3 gap-3">
              <Link
                v-for="subCategory in mainCategory.sub_categories"
                :key="subCategory.id"
                :href="`/equipment/${mainCategory.slug}/${subCategory.slug}`"
                class="group/sub flex flex-col items-center gap-2 p-3 rounded-lg hover:bg-primary/5 transition-colors"
              >
                <!-- Sub Category Icon -->
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center group-hover/sub:bg-primary/10 transition">
                  <img
                    v-if="subCategory.icon"
                    :src="`/storage/${subCategory.icon}`"
                    :alt="subCategory.name"
                    class="w-7 h-7 object-contain"
                  />
                  <svg v-else class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10m0-10L4 7m16 0L8 11m8-4v10m0-10l8-4" />
                  </svg>
                </div>

                <!-- Sub Category Name -->
                <span class="text-xs font-medium text-gray-700 text-center line-clamp-2 group-hover/sub:text-primary transition">
                  {{ subCategory.name }}
                </span>
              </Link>
            </div>
          </div>

          <!-- Empty Sub Categories -->
          <div v-else class="p-4 text-center text-xs text-gray-500">
            No subcategories
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

import {MainCategory} from "@/types";

const categories = ref<MainCategory[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const fetchCategories = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get('/api/categories');
    categories.value = response.data.data || response.data;
  } catch (err) {
    error.value = 'Failed to load categories. Please try again later.';
    console.error('Error fetching categories:', err);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchCategories();
});
</script>

<style scoped>
@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
