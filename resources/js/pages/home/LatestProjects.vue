<template>
  <section class="py-16 bg-gradient-to-b from-white via-primary/5 to-white">
  <div class="container mx-auto px-6">
    <!-- Section Title -->
    <h2 class="text-3xl md:text-4xl font-bold text-primary text-center mb-12">
      Latest Projects
    </h2>

    <!-- Project Grid -->
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
