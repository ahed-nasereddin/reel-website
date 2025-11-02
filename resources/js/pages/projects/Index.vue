<template>
  <Head>
    <title>Our Projects | Lighting & Camera Crew Services</title>
    <meta
      name="description"
      content="Discover our lighting, camera, and crew service projects across events, films, and productions."
    />
    <!-- Open Graph -->
    <meta property="og:title" content="Our Projects | ReelQuip Films" />
    <meta
      property="og:description"
      content="Discover our lighting, camera, and crew service projects across events, films, and productions."
    />
    <meta property="og:type" content="website" />
    <meta property="og:url" :content="location" />
    <meta property="og:image" content="/default-project.jpg" />
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Our Projects | ReelQuip Films" />
    <meta
      name="twitter:description"
      content="Discover our lighting, camera, and crew service projects across events, films, and productions."
    />
    <meta name="twitter:image" content="/default-project.jpg" />
  </Head>

  <section class="py-10 bg-primary/1 mt-24 min-h-screen">
    <div class="container mx-auto px-6">
      <!-- Title -->
      <div class="flex justify-center items-center">
        <h2 class="text-3xl font-bold mb-6">Projects</h2>
      </div>
   
      <!-- Grid of projects -->
      <div v-if="projects.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <ProjectCard v-for="project in projects" :key="project.id" :project="project" />
      </div>

      <!-- No projects -->
      <div v-else class="text-gray-500">
        <span v-if="loading">Loading..</span>
        <span v-else>No projects found.</span>
      </div>

      <!-- Pagination -->
      <div v-if="meta.total > meta.per_page" class="flex justify-center items-center gap-2 mt-8">
        <button
          @click="fetchProjects(meta.current_page - 1)"
          :disabled="meta.current_page === 1"
          class="px-4 py-2 bg-gray-200 rounded-xl disabled:opacity-50 hover:bg-gray-300"
        >
          Prev
        </button>

        <span class="font-medium">Page {{ meta.current_page }} of {{ meta.last_page }}</span>

        <button
          @click="fetchProjects(meta.current_page + 1)"
          :disabled="meta.current_page === meta.last_page"
          class="px-4 py-2 bg-gray-200 rounded-xl disabled:opacity-50 hover:bg-gray-300"
        >
          Next
        </button>
      </div>
    </div>
  </section>
</template>


<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { Project } from "@/types";
import ProjectCard from "./ProjectCard.vue";
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
defineOptions({ layout: AppLayout });
const location=window.location.href
const props=defineProps<{
  projects: Project[];
}>();
const projects=props.projects
const meta = ref({
  current_page: 1,
  last_page: 1,
  per_page: 9,
  total: 0,
});

</script>

