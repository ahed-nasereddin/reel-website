<template>
 <Link
    :key="project.id"
    :href="route('projects.show', { slug: project.slug })"
    class="block bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:shadow-primary border-2 border-primary hover:p-2 transition transform hover:-translate-y-2 overflow-hidden"
  >
  
    <img
      v-if="project.main_image"
      :src="`/storage/${project.main_image}`"
      alt="project image"
      class="w-full h-40 object-cover rounded-xl  rounded-b-none mb-3"
    />
    <div class="px-2 py-1 text-primary">
        <h3 class="text-xl font-bold mb-2">{{ project.name }}</h3>
    <p v-html="project.description" class="text-secondary/50 text-sm line-clamp-3"></p>
    </div>
     
    
  </Link>
</template>

<script setup lang="ts">
import { Project } from '@/types';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
defineOptions({ layout: AppLayout });
defineProps<{
  project: Project;
}>();
</script>
