<template>
  <Head>
  <title>ReelQuip Films | Professional Lighting & Camera Services</title>
  <meta name="description" content="Professional lighting and camera services for your projects." />
  <meta property="og:title" content="ReelQuip Films" />
  <meta property="og:description" content="Professional lighting and camera services for your projects." />
  <meta property="og:image" content="/storage/images/about-us.jpg" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://reelquipfilms.com" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="ReelQuip Films" />
  <meta name="twitter:description" content="Professional lighting and camera services for your projects." />
  <meta name="twitter:image" content="/storage/images/about-us.jpg" />
</Head>

  <div>
      <HeaderSlider v-if="props.sliders" :slides="props.sliders"/>
      <Services v-if="props.services" :services="props.services" />
      <About/>
      <LatestProjects v-if="props.latestProjects" :latestProjects="props.latestProjects"/>
      <Testimonials/>
      <CTA/>

      <WhatsappButton :number="props.contact?.whatsapp"/>
    
  </div>
</template>

<script setup lang="ts">
import HeaderSlider from '../../components/HeaderSlider.vue';
import Services from './Services.vue';
import LatestProjects from './LatestProjects.vue';
import Testimonials from './Testimonials.vue';
import OurTeam from './OurTeam.vue';
import CTA from './CTA.vue';
import { Head } from '@inertiajs/vue3';

import { ref, onMounted, watch } from "vue";
import axios from "axios";
import  { Slider,Service,ProjectPreview,TeamMember, Contact } from "@/types";
import WhatsappButton from '@/components/WhatsappButton.vue';
import About from './About.vue';

import AppLayout from '@/layouts/AppLayout.vue';
defineOptions({ layout: AppLayout });
const homeContent = ref({
  title: "ReelQuip Films",
  description: "Professional lighting and camera services for your projects.",
  image: "storage/images/about-us.jpg",
});
const props=defineProps({
 sliders : ref<Slider[]>([]),
 services : ref<Service[]>([]),
 latestProjects:ref<ProjectPreview[]>([]),
 teamMembers : ref<TeamMember[]>([]),
 contact:ref<Contact>()
});

// const testimonials = ref([]);
// Watch the homeContent (in case it is fetched asynchronously)


onMounted(async () => {
  // try {
  //   const sliderCacheKey = "sliders_cache";
  //   const cachedSliders = localStorage.getItem(sliderCacheKey);
    
  //   if (cachedSliders) {
  //     sliders.value = JSON.parse(cachedSliders);
  //   }

  //   const [slidersRes, servicesRes, latestProjectsRes, teamMembersRes, contactRes] = await Promise.all([
  //     axios.get("/api/sliders"),
  //     axios.get("/api/services"),
  //     axios.get("/api/latestprojects"),
  //     axios.get("/api/team"),
  //     axios.get("/api/contact"),
  //   ]);

  //   sliders.value = slidersRes.data;
  //   localStorage.setItem(sliderCacheKey, JSON.stringify(slidersRes.data));

  //   services.value = servicesRes.data.data;
  //   latestProjects.value = latestProjectsRes.data;
  //   teamMembers.value = teamMembersRes.data.data;
  //   contact.value = contactRes.data.data;

  // } catch (error) {
  //   console.error("Error fetching home page data:", error);
  // }


});

</script>
