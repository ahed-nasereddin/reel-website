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
      <CategoriesShowcase/>
      <About/>
      <LatestProjects v-if="props.latestProjects" :latestProjects="props.latestProjects"/>
      <Testimonials v-if="props.testimonials" :testimonials="props.testimonials" />

      <section id="contact" class="bg-slate-50 py-16">
        <div class="mx-auto max-w-6xl px-6">
          <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr] items-center">
            <div class="rounded-[2rem] bg-white p-8 shadow-lg ring-1 ring-slate-200">
              <p class="text-sm uppercase tracking-[0.32em] text-primary font-semibold">Contact Us</p>
              <h2 class="mt-4 text-3xl font-bold text-slate-900">Let’s make your next production shine.</h2>
              <p class="mt-4 text-slate-600 leading-7">Reach out for equipment rentals, crew packages, location lighting, and fast project support. We’re ready to help with quotes, availability, or a custom shoot plan.</p>

              <div class="mt-8 space-y-6">
                <div v-if="contact?.address" class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                  <p class="text-sm text-slate-500">Office Address</p>
                  <p class="mt-2 text-lg font-semibold text-slate-900">{{ contact.address }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                  <a v-if="contact?.mobile_number" :href="`tel:${contact.mobile_number}`" class="group block rounded-3xl border border-slate-200 bg-white p-5 transition hover:border-primary hover:bg-primary/5">
                    <p class="text-sm text-slate-500">Call us</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900 group-hover:text-primary">{{ contact.mobile_number }}</p>
                  </a>

                  <a v-if="contact?.whatsapp" :href="`https://wa.me/${contact.whatsapp}`" target="_blank" class="group block rounded-3xl border border-slate-200 bg-white p-5 transition hover:border-green-500 hover:bg-green-50">
                    <p class="text-sm text-slate-500">WhatsApp</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900 group-hover:text-green-600">Chat on WhatsApp</p>
                  </a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                  <a v-if="contact?.facebook" :href="contact.facebook" target="_blank" class="group block rounded-3xl border border-slate-200 bg-white p-5 transition hover:border-blue-600 hover:bg-blue-50">
                    <p class="text-sm text-slate-500">Facebook</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900 group-hover:text-blue-600">Follow us</p>
                  </a>

                  <a v-if="contact?.instagram" :href="contact.instagram" target="_blank" class="group block rounded-3xl border border-slate-200 bg-white p-5 transition hover:border-pink-500 hover:bg-pink-50">
                    <p class="text-sm text-slate-500">Instagram</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900 group-hover:text-pink-500">See our work</p>
                  </a>
                </div>
              </div>
            </div>

            <div class="rounded-[2rem] overflow-hidden shadow-lg ring-1 ring-slate-200">
              <iframe
                v-if="contact?.coordinates"
                class="h-96 w-full"
                :src="`https://www.google.com/maps?q=${contact.coordinates.latitude},${contact.coordinates.longitude}&hl=es;z=14&output=embed`"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
              <div v-else class="flex h-96 items-center justify-center bg-slate-100 text-slate-500">Map unavailable</div>
            </div>
          </div>
        </div>
      </section>

      <!-- <CTA/> -->

      <WhatsappButton :number="props.contact?.whatsapp"/>
    </div>
</template>

<script setup lang="ts">
import HeaderSlider from '../../components/HeaderSlider.vue';
import Services from './Services.vue';
import CategoriesShowcase from './CategoriesShowcase.vue';
import LatestProjects from './LatestProjects.vue';
import Testimonials from './Testimonials.vue';
import OurTeam from './OurTeam.vue';
import CTA from './CTA.vue';
import { Head } from '@inertiajs/vue3';

import { ref, onMounted, watch } from "vue";
import axios from "axios";
import  { Slider,Service,ProjectPreview,TeamMember, Contact,Testimonial } from "@/types";
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
 testimonials : ref<Testimonial[]>([]),
 contact:ref<Contact>()
});
const contact = props.contact;

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
