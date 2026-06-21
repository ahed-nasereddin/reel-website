<template>
  <Head>
    <title>{{ seo.title }}</title>
    <meta name="description" :content="seo.description" />
    <meta name="keywords" :content="seo.keywords" />
    <link rel="canonical" :href="seo.canonical" />
    <meta property="og:title" :content="seo.og.title" />
    <meta property="og:description" :content="seo.og.description" />
    <meta property="og:image" :content="seo.og.image" />
    <meta property="og:url" :content="seo.og.url" />
    <meta property="og:type" :content="seo.og.type" />
    <meta name="twitter:card" :content="seo.twitter.card" />
    <meta name="twitter:title" :content="seo.twitter.title" />
    <meta name="twitter:description" :content="seo.twitter.description" />
    <meta name="twitter:image" :content="seo.twitter.image" />
  </Head>

  <div class="min-h-screen bg-white text-black selection:bg-[#14B8B8] selection:text-white">

    <!-- ═══════════════════════════════════════════════════ -->
    <!-- MAIN SPLIT LAYOUT                                   -->
    <!-- ═══════════════════════════════════════════════════ -->
    <main class="pt-32 relative flex flex-col lg:flex-row">

      <!-- ─────────────────────────────────────────────── -->
      <!-- LEFT: VISUAL STAGE (Sticky on Desktop)          -->
      <!-- ─────────────────────────────────────────────── -->
      <section class="relative w-full lg:w-[58%] h-[50vh] sm:h-[60vh] lg:h-screen lg:sticky lg:top-0 bg-[#E8EAED] overflow-hidden">
        <!-- Cinematic gradient overlays -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/25 via-transparent to-black/10  pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-transparent pointer-events-none"></div>

        <!-- Back to Catalog (inside image panel) -->
        <Link
          href="/items"
          class="absolute top-6 left-6 z-20 group flex items-center gap-3 bg-white/80 backdrop-blur-xl border border-white/30 pl-2.5 pr-5 py-2 rounded-full shadow-lg shadow-black/10 transition-all duration-300 hover:border-[#14B8B8]/60 hover:bg-white"
        >
          <div class="bg-black p-2 rounded-full text-white transition-transform duration-300 group-hover:-translate-x-0.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
          </div>
          <span class="text-[10px] uppercase tracking-[0.3em] font-bold text-black">Catalog</span>
        </Link>

        <!-- Hero Image -->
        <img
          :src="displayImage"
          :alt="item.title || item.name"
          class="w-full h-full object-cover transition-transform duration-[1200ms] ease-out hover:scale-[1.03]"
        />

        <!-- Gallery Progress Indicator -->
        <div v-if="galleryImages.length > 1" class="absolute bottom-8 left-8  flex items-center gap-2">
          <button
            v-for="(img, i) in galleryImages"
            :key="i"
            type="button"
            @click="selectGalleryImage(i)"
            class="relative h-1 rounded-full overflow-hidden transition-all duration-500"
            :class="activeImageIndex === i ? 'w-10 bg-white' : 'w-6 bg-white/30 hover:bg-white/50'"
            :aria-label="`View image ${i + 1}`"
          >
            <div
              v-if="activeImageIndex === i"
              class="absolute inset-0 bg-white rounded-full"
            ></div>
          </button>
        </div>

        <!-- Gallery Thumbnail Strip -->
        <div v-if="galleryImages.length > 1" class="absolute bottom-8 right-8  flex gap-2">
          <button
            v-for="(img, i) in galleryImages.slice(0, 4)"
            :key="'thumb-' + i"
            type="button"
            @click="selectGalleryImage(i)"
            class="w-16 h-16 rounded-xl overflow-hidden border-2 transition-all duration-300 hover:scale-105"
            :class="activeImageIndex === i ? 'border-white shadow-lg shadow-black/20' : 'border-white/20 opacity-70 hover:opacity-100'"
          >
            <img :src="img" class="w-full h-full object-cover" :alt="`Gallery image ${i + 1}`" />
          </button>
          <button
            v-if="galleryImages.length > 4"
            type="button"
            @click="openLightbox(0)"
            class="w-16 h-16 rounded-xl bg-black/40 backdrop-blur-sm border-2 border-white/20 flex items-center justify-center text-white text-xs font-bold transition-all duration-300 hover:bg-black/60"
          >
            +{{ galleryImages.length - 4 }}
          </button>
        </div>

        <!-- Fullscreen trigger -->
        <button
          type="button"
          @click="openLightbox(activeImageIndex)"
          class="absolute top-8 right-8  bg-black/30 backdrop-blur-sm p-3 rounded-full text-white/80 transition-all duration-300 hover:bg-black/50 hover:text-white hover:scale-110"
          aria-label="View fullscreen"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
          </svg>
        </button>
      </section>

      <!-- ─────────────────────────────────────────────── -->
      <!-- RIGHT: DATA STACK                               -->
      <!-- ─────────────────────────────────────────────── -->
      <section class="w-full lg:w-[42%] px-6 py-10 sm:px-10 lg:px-16 xl:px-20 lg:py-20 flex flex-col gap-14">

        <!-- ── HEADER BLOCK ── -->
        <header class="space-y-5">
          <div class="flex items-center gap-3">
            <span class="inline-block w-8 h-px bg-[#14B8B8]"></span>
            <span class="text-[10px] uppercase tracking-[0.4em] text-[#14B8B8] font-black">
              {{ item.category?.name || 'Equipment' }}
            </span>
          </div>

          <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-[-0.04em] leading-[0.95]">
            {{ item.title || item.name }}
          </h1>

          <div class="flex flex-wrap gap-2 pt-1">
            <span class="inline-flex items-center px-3 py-1.5 bg-black text-white rounded-lg text-[10px] uppercase font-bold tracking-[0.15em]">
              {{ item.brand?.name || 'ReelQuip' }}
            </span>
            <span
              v-if="item.category?.name"
              class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-black rounded-lg text-[10px] uppercase font-bold tracking-[0.15em]"
            >
              {{ item.category.name }}
            </span>
          </div>
        </header>

        <!-- ── DIVIDER ── -->
        <div class="w-full h-px bg-gradient-to-r from-gray-200 via-gray-200 to-transparent"></div>

        <!-- ── COMMAND CARD (Price / CTA) ── -->
        <div class="relative p-8 sm:p-10 bg-white border border-gray-200/80 rounded-[1.75rem] shadow-[0_24px_64px_rgba(0,0,0,0.04)]">
          <!-- Subtle corner accent -->
          <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-[#14B8B8]/10 to-transparent rounded-tr-[1.75rem] pointer-events-none"></div>

          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-6 mb-8">
            <!-- Price -->
            <div>
              <p class="text-[10px] uppercase tracking-[0.35em] text-gray-400 font-semibold mb-2">
                Daily Rental Rate
              </p>
              <div v-if="item.price" class="flex items-baseline gap-1.5">
                <span class="text-base font-medium text-gray-400">AED</span>
                <span class="text-4xl sm:text-5xl font-bold tracking-tight text-black">{{ item.price }}</span>
              </div>
              <div v-else>
                <span class="text-2xl sm:text-3xl font-bold text-black">Contact for Pricing</span>
              </div>
              <p v-if="item.unit" class="text-xs text-gray-400 mt-1.5">{{ item.unit }} / day</p>
            </div>

            <!-- Availability Badge -->
            <div
              class="flex items-center gap-2.5 px-4 py-2.5 rounded-full self-start"
              :class="item.available
                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
                : 'bg-red-50 text-red-600 border border-red-200/60'"
            >
              <span
                class="w-2 h-2 rounded-full"
                :class="item.available ? 'bg-emerald-500 animate-pulse' : 'bg-red-500'"
              ></span>
              <span class="text-[10px] font-black uppercase tracking-[0.2em]">
                {{ item.available ? 'Ready for Dispatch' : 'On Assignment' }}
              </span>
            </div>
          </div>

          <!-- WhatsApp CTA -->
          <a
            v-if="whatsappLink"
            :href="whatsappLink"
            target="_blank"
            rel="noopener noreferrer"
            class="group relative flex items-center justify-center gap-3 w-full bg-black text-white py-5 rounded-2xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-[#14B8B8]/20"
          >
            <!-- Hover gradient sweep -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#14B8B8] to-[#0FA0A0] translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500 ease-out"></div>
            <div class="relative flex items-center gap-3">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20.52 3.48A11.86 11.86 0 0 0 12 0C5.373 0 .02 5.353 0 12c0 2.106.551 4.18 1.597 6.002L0 24l6.214-1.612A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.197-1.247-6.195-3.48-8.52zM12 21.6c-1.418 0-2.804-.384-4.02-1.108l-.287-.168-3.693.958.992-3.6-.177-.29A9.6 9.6 0 1 1 21.6 12 9.6 9.6 0 0 1 12 21.6z"/>
                <path d="M17.4 14.8c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.18.2-.36.22-.66.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2 0-.37-.05-.52-.05-.15-.67-1.62-.92-2.22-.24-.57-.48-.5-.66-.5-.17 0-.37 0-.57 0-.2 0-.52.07-.8.37-.27.3-1.04 1.01-1.04 2.47 0 1.46 1.06 2.87 1.2 3.07.14.2 2.07 3.33 5.02 4.67 2.96 1.34 3.01.89 3.57.83.56-.06 1.77-.72 2.02-1.41.25-.7.25-1.29.18-1.41-.07-.12-.27-.2-.57-.35z"/>
              </svg>
              <span class="text-sm font-bold uppercase tracking-[0.2em]">Inquire via WhatsApp</span>
              <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </div>
          </a>

          <button
            type="button"
            @click="handleAddToCart"
            class="mt-4 w-full rounded-2xl bg-primary text-white py-3.5 text-sm font-bold uppercase tracking-[0.15em] transition-colors duration-300 hover:bg-accent hover:text-primary"
          >
            Add to Cart
          </button>

          
        </div>

        <!-- ── EQUIPMENT INTELLIGENCE (Description) ── -->
        <div class="space-y-5" v-if="item.description">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] uppercase tracking-[0.3em] font-black text-black">Equipment Intelligence</h3>
            <div class="flex-1 h-px bg-gray-200"></div>
          </div>
          <div
            class="prose prose-slate prose-sm max-w-none text-gray-600 leading-[1.85] [&_p]:mb-4 [&_ul]:pl-4 [&_li]:marker:text-[#14B8B8]"
            v-html="item.description"
          ></div>
        </div>

        <!-- ── SPECIFICATION SCHEMATIC ── -->
        <div v-if="specRows.length" class="space-y-5">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] uppercase tracking-[0.3em] font-black text-black">Technical Specifications</h3>
            <div class="flex-1 h-px bg-gray-200"></div>
          </div>

          <div class="grid grid-cols-2 gap-px bg-gray-200 border border-gray-200 rounded-2xl overflow-hidden">
            <div
              v-for="(spec, index) in specRows"
              :key="index"
              class="bg-white p-5 sm:p-6 transition-colors duration-200 hover:bg-gray-50"
            >
              <dt class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-semibold mb-2">{{ spec.key }}</dt>
              <dd class="text-sm font-bold text-black leading-snug">{{ spec.value }}</dd>
            </div>
            <!-- Fill last cell if odd number of specs -->
            <div v-if="specRows.length % 2 !== 0" class="bg-white p-5 sm:p-6"></div>
          </div>
        </div>

        <!-- ── RELATED GEAR ── -->
        <div v-if="relatedItems.length" class="space-y-5">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] uppercase tracking-[0.3em] font-black text-black">Related Equipment</h3>
            <div class="flex-1 h-px bg-gray-200"></div>
          </div>

          <div class="grid gap-3 sm:grid-cols-2">
            <Link
              v-for="related in relatedItems.slice(0, 4)"
              :key="related.id"
              :href="related.url"
              class="group relative flex flex-col justify-between p-5 bg-white border border-gray-200/80 rounded-2xl transition-all duration-300 hover:border-[#14B8B8]/50 hover:shadow-lg hover:shadow-[#14B8B8]/10"
            >
              <div>
                <p class="font-bold text-sm text-black group-hover:text-[#14B8B8] transition-colors duration-300 leading-snug">
                  {{ related.title || related.name }}
                </p>
                <p class="mt-1.5 text-[10px] uppercase tracking-[0.15em] text-gray-400 font-semibold">
                  {{ related.brand?.name || 'ReelQuip' }} · {{ related.category?.name || 'Equipment' }}
                </p>
              </div>
              <svg class="w-4 h-4 text-gray-300 mt-4 self-end transition-all duration-300 group-hover:text-[#14B8B8] group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </Link>
          </div>
        </div>

        <!-- ── FOOTER SPACER ── -->
        <div class="h-8 lg:h-0"></div>
      </section>
    </main>

    <!-- ═══════════════════════════════════════════════════ -->
    <!-- MOBILE STICKY CTA (Bottom Bar)                      -->
    <!-- ═══════════════════════════════════════════════════ -->
    <div
      v-if="whatsappLink"
      class="fixed bottom-0 inset-x-0  lg:hidden bg-white/90 backdrop-blur-xl border-t border-gray-200/80 px-4 py-3 safe-area-bottom"
    >
      <div class="flex items-center justify-between gap-4">
        <div class="min-w-0">
          <p class="text-xs text-gray-400 truncate">{{ item.title || item.name }}</p>
          <p class="font-bold text-lg" v-if="item.price">
            <span class="text-xs font-medium text-gray-400">AED</span> {{ item.price }}
          </p>
          <p class="font-bold text-sm text-gray-600" v-else>Contact for Price</p>
        </div>
        <a
          :href="whatsappLink"
          target="_blank"
          rel="noopener noreferrer"
          class="flex-shrink-0 flex items-center gap-2 bg-black text-white px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-[0.15em] transition-colors duration-300 hover:bg-[#14B8B8]"
        >
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20.52 3.48A11.86 11.86 0 0 0 12 0C5.373 0 .02 5.353 0 12c0 2.106.551 4.18 1.597 6.002L0 24l6.214-1.612A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.197-1.247-6.195-3.48-8.52zM12 21.6c-1.418 0-2.804-.384-4.02-1.108l-.287-.168-3.693.958.992-3.6-.177-.29A9.6 9.6 0 1 1 21.6 12 9.6 9.6 0 0 1 12 21.6z"/>
            <path d="M17.4 14.8c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.18.2-.36.22-.66.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2 0-.37-.05-.52-.05-.15-.67-1.62-.92-2.22-.24-.57-.48-.5-.66-.5-.17 0-.37 0-.57 0-.2 0-.52.07-.8.37-.27.3-1.04 1.01-1.04 2.47 0 1.46 1.06 2.87 1.2 3.07.14.2 2.07 3.33 5.02 4.67 2.96 1.34 3.01.89 3.57.83.56-.06 1.77-.72 2.02-1.41.25-.7.25-1.29.18-1.41-.07-.12-.27-.2-.57-.35z"/>
          </svg>
          Inquire
        </a>
      </div>
    </div>

    <!-- Lightbox -->
    <VueEasyLightbox
      :visible="showLightbox"
      :imgs="galleryImages"
      :index="lightboxIndex"
      @hide="showLightbox = false"
    />
  </div>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import VueEasyLightbox from "vue-easy-lightbox";
import AppLayout from "@/layouts/AppLayout.vue";

import { useCart } from '@/composables/useCart';

defineOptions({ layout: AppLayout });

const props = defineProps<{
  item: Record<string, any>;
  seo: Record<string, any>;
  relatedItems: any[];
  whatsapp_number?: string | null;
}>();

const seo = props.seo;
const whatsappNumber = props.whatsapp_number ?? null;

// ── Gallery State ──
const showLightbox = ref(false);
const lightboxIndex = ref(0);
const activeImageIndex = ref(0);

function openLightbox(index: number) {
  lightboxIndex.value = index;
  showLightbox.value = true;
}

function selectGalleryImage(index: number) {
  activeImageIndex.value = index;
}

const galleryImages = computed(() => {
  if (Array.isArray(props.item.images) && props.item.images.length) {
    return props.item.images;
  }
  return props.item.featured_image ? [props.item.featured_image] : ["/default-project.jpg"];
});

const displayImage = computed(() => galleryImages.value[activeImageIndex.value] || "/default-project.jpg");

// ── Related Items ──
const relatedItems = computed(() =>
  Array.isArray(props.relatedItems) ? props.relatedItems : []
);

// ── Specifications ──
const specRows = computed(() => {
  if (Array.isArray(props.item.specs)) {
    return props.item.specs.map((value: any, index: number) => ({
      key: `Feature ${index + 1}`,
      value,
    }));
  }
  if (props.item.specs && typeof props.item.specs === "object") {
    return Object.entries(props.item.specs).map(([key, value]) => ({
      key,
      value,
    }));
  }
  return [];
});

// ── WhatsApp Link ──
const whatsappLink = computed(() => {
  if (!whatsappNumber) return null;
  const cleaned = (whatsappNumber || "").toString().replace(/[^0-9]/g, "");
  if (!cleaned) return null;

  const itemTitle = props.item.title || props.item.name || "";
  const itemUrl =
    props.item.url && typeof props.item.url === "string"
      ? props.item.url
      : window.location.href;
  const message = `Hello, I'm interested in ${itemTitle} (${itemUrl}). Could you share availability and pricing?`;

  return `https://wa.me/${cleaned}?text=${encodeURIComponent(message)}`;
});

// Cart
const { addToCart, initializeCart } = useCart();
onMounted(() => {
  initializeCart();
});

const handleAddToCart = () => {
  addToCart(props.item);
};
</script>

<style scoped>
/* Safe area inset for mobile sticky bar */
.safe-area-bottom {
  padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
}
</style>