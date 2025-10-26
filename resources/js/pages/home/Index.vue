<template>
  <div>
      <HeaderSlider v-if="sliders" :slides="sliders"/>
      <Services v-if="services" :services="services" />
      <About/>
        <OurTeam  v-if="teamMembers.length>0" :teamMembers="teamMembers"/>
      <LatestProjects v-if="latestProjects" :latestProjects="latestProjects"/>
      <Testimonials/>
      <CTA/>

      <WhatsappButton :number="contact?.whatsapp"/>
    
  </div>
</template>

<script setup lang="ts">
import HeaderSlider from '../../components/HeaderSlider.vue';
import Services from './Services.vue';
import LatestProjects from './LatestProjects.vue';
import Testimonials from './Testimonials.vue';
import About from './About.vue';
import OurTeam from './OurTeam.vue';
import CTA from './CTA.vue';
import { useHead } from "@vueuse/head";

import { ref, onMounted, watch } from "vue";
import axios from "axios";
import  { Slider,Service,ProjectPreview,TeamMember, Contact } from "@/types";
import WhatsappButton from '@/components/WhatsappButton.vue';


const homeContent = ref({
  title: "ReelQuip Films",
  description: "Professional lighting and camera services for your projects.",
  image: "storage/images/about-us.jpg",
});
const sliders = ref<Slider[]>([]);
const services = ref<Service[]>([]);
const latestProjects=ref<ProjectPreview[]>([]);
const teamMembers = ref<TeamMember[]>([]);
const contact=ref<Contact>();
// const testimonials = ref([]);
// Watch the homeContent (in case it is fetched asynchronously)

function setMetaTags(){
  useHead({
    title: homeContent.value.title,
    meta: [
      { name: "description", content: homeContent.value.description?.substring(0, 160) || "" },
      { property: "og:title", content: homeContent.value.title },
      { property: "og:description", content: homeContent.value.description?.substring(0, 160) || "" },
      { property: "og:image", content: homeContent.value.image || "/logo.jpg" },
      { property: "og:type", content: "website" },
      { property: "og:url", content: window.location.href },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:title", content: homeContent.value.title },
      { name: "twitter:description", content: homeContent.value.description?.substring(0, 160) || "" },
      { name: "twitter:image", content: homeContent.value.image || "/logo.jpg" },
    ],
  });
}
onMounted(async () => {
  try {
    const sliderCacheKey = "sliders_cache";
    const cachedSliders = localStorage.getItem(sliderCacheKey);
    
    if (cachedSliders) {
      sliders.value = JSON.parse(cachedSliders);
    }

    const [slidersRes, servicesRes, latestProjectsRes, teamMembersRes, contactRes] = await Promise.all([
      axios.get("/api/sliders"),
      axios.get("/api/services"),
      axios.get("/api/latestprojects"),
      axios.get("/api/team"),
      axios.get("/api/contact"),
    ]);

    sliders.value = slidersRes.data;
    localStorage.setItem(sliderCacheKey, JSON.stringify(slidersRes.data));

    services.value = servicesRes.data.data;
    latestProjects.value = latestProjectsRes.data;
    teamMembers.value = teamMembersRes.data.data;
    contact.value = contactRes.data.data;

  } catch (error) {
    console.error("Error fetching home page data:", error);
  }

  setMetaTags();
});

</script>
