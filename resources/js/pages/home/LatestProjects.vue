<template>
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-12">Latest Projects</h2>
      <div class="grid md:grid-cols-3 gap-8">
        
          <ProjectCard
          v-for="project in latestProjects"
          :key="project.id"
          :project="project"
        />
      
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Project } from '../../types';
import ProjectCard from '../projects/ProjectCard.vue';


const props=defineProps<{
  latestProjects:Project[];
}>();

</script>
