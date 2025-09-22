<template>
  <RouterLink
         
          :key="project.id"
          :to="{ name: 'project-details', params: { slug: project.slug } }"
          class="block bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:shadow-primary hover:border-1 hover:border-primary hover:p-2  transition transform hover:-translate-y-2 overflow-hidden"
        >
  
    <img
      v-if="project.main_image"
      :src="project.main_image"
      alt="project image"
      class="w-full h-40 object-cover rounded-xl rounded-b-none mb-3"
    />
    <div class="px-2 py-1">
        <h3 class="text-xl font-semibold mb-2">{{ project.name }}</h3>
    <p v-html="project.description" class="text-gray-600 text-sm line-clamp-3"></p>
    </div>
     
    
  </RouterLink>
</template>

<script setup lang="ts">
import { Project } from '@/types';

defineProps<{
  project: Project;
}>();
</script>
