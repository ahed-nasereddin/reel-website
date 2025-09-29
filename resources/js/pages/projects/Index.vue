<template>
  <section class="py-10 bg-primary/1  mt-14 min-h-screen   ">
    <div class="container mx-auto px-6">
      <!-- Title -->
      <h2 class="text-3xl font-bold mb-6">Projects</h2>

      <!-- Grid of projects -->
      <div
        v-if="projects.length"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"
      >
        <ProjectCard
          v-for="project in projects"
          :key="project.id"
          :project="project"
        />
      </div>

      <!-- No projects -->
      <p v-else class="text-gray-500">No projects found.</p>

      <!-- Pagination -->
      <div v-if="meta.total > meta.per_page" class="flex justify-center items-center gap-2 mt-8">
        <button
          @click="fetchProjects(meta.current_page - 1)"
          :disabled="meta.current_page === 1"
          class="px-4 py-2 bg-gray-200 rounded-xl disabled:opacity-50 hover:bg-gray-300"
        >
          Prev
        </button>

        <span class="font-medium">
          Page {{ meta.current_page }} of {{ meta.last_page }}
        </span>

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
import { useHead } from "@vueuse/head"

useHead({
  title: "Our Projects | Lighting & Camera Crew Services",
  meta: [
    { name: "description", content: "Discover our lighting, camera, and crew service projects across events, films, and productions." }
  ]
})
const projects = ref<Project[]>([]);
const meta = ref({
  current_page: 1,
  last_page: 1,
  per_page: 9,
  total: 0,
});

const fetchProjects = async (page = 1) => {
  try {
    const res = await axios.get(`/api/projects?page=${page}`);
    projects.value = res.data.data;
    meta.value = res.data.meta;
  } catch (error) {
    console.error("Error fetching projects:", error);
  }
};

onMounted(() => {
  fetchProjects();
});
</script>
