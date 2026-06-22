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

  <section class="pt-32 pb-16 bg-gradient-to-b from-white via-primary/5 to-white min-h-screen">
    <div class="container mx-auto px-6">
      <div class="mb-10 rounded-3xl border border-primary/10 bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">Equipment</p>
            <h1 class="mt-3 text-4xl font-bold text-primary">{{ pageTitle }}</h1>
            <p class="mt-3 max-w-3xl text-lg text-secondary" v-html="pageSubtitle "></p>
          </div>

          <div class="flex flex-wrap gap-3">
            <Link href="/items" class="rounded-full border border-primary px-5 py-3 text-sm font-semibold text-primary transition hover:bg-primary hover:text-white">
              Browse all equipment
            </Link>
            <Link v-if="category" :href="`/equipment/${category.slug}`" class="rounded-full border border-primary/20 px-5 py-3 text-sm text-secondary transition hover:border-primary hover:text-primary">
              Category overview
            </Link>
          </div>
        </div>
      </div>

      <div class="grid gap-6 lg:grid-cols-[300px_1fr]">
        <aside class="space-y-6">
          <div class="rounded-3xl border border-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-primary mb-4">Refine results</h2>
            <form @submit.prevent="submitFilters" class="space-y-4">
              <div>
                <label class="mb-2 block text-sm font-medium text-secondary">Search</label>
                <input
                  v-model="filters.q"
                  type="search"
                  placeholder="Search within this category"
                  class="w-full rounded-2xl border border-primary/20 bg-slate-50 px-4 py-3 text-sm text-secondary outline-none focus:border-primary"
                />
              </div>

              <div>
                <label class="mb-2 block text-sm font-medium text-secondary">Brand</label>
                <select v-model="filters.brand_slug" class="w-full rounded-2xl border border-primary/20 bg-slate-50 px-4 py-3 text-sm text-secondary outline-none">
                  <option value="">All brands</option>
                  <option v-for="brand in brands" :key="brand.id" :value="brand.slug">{{ brand.name }}</option>
                </select>
              </div>

              <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center
          rounded-full bg-primary px-4 py-3 text-white transition 
            hover:bg-accent hover:text-primary hover:border hover:border-primary
            text-sm font-semibold text-white transition ">
                  Apply
                </button>
                <button type="button" @click="resetFilters" class="text-sm text-secondary underline underline-offset-2">
                  Reset
                </button>
              </div>
            </form>
          </div>

          <div class="rounded-3xl border border-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-primary mb-4">Browse categories</h2>
            <div class="space-y-2">
              <Link
                v-for="categorySummary in categories"
                :key="categorySummary.id"
                :href="`/equipment/${categorySummary.slug}`"
                class="block rounded-2xl border border-primary/10 bg-slate-50 px-4 py-3 text-sm text-secondary transition hover:border-primary hover:bg-primary/5 hover:text-primary"
              >
                {{ categorySummary.name }}
              </Link>
            </div>
          </div>
        </aside>

        <div class="space-y-6">
          <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <ItemCard v-for="item in items" :key="item.id" :item="item" />
          </div>

          <div v-if="items.length === 0" class="rounded-3xl border border-primary/10 bg-white p-10 text-center text-lg text-secondary shadow-sm">
            No equipment found for this selection.
          </div>

          <div class="flex flex-col gap-3 rounded-3xl border border-primary/10 bg-white p-5 shadow-sm md:flex-row md:items-center md:justify-between">
            <div class="text-sm text-secondary">
              Showing {{ items.length }} of {{ meta.total }} items
            </div>
            <div class="flex flex-wrap items-center gap-2">
              <Link :href="pageUrl(meta.current_page - 1)" class="rounded-full border border-primary px-4 py-2 text-sm font-medium transition hover:bg-primary hover:text-white" :class="{ 'cursor-not-allowed opacity-50': meta.current_page <= 1 }">
                Prev
              </Link>
              <span class="text-sm font-semibold text-secondary">Page {{ meta.current_page }} / {{ meta.last_page }}</span>
              <Link :href="pageUrl(meta.current_page + 1)" class="rounded-full border border-primary px-4 py-2 text-sm font-medium transition hover:bg-primary hover:text-white" :class="{ 'cursor-not-allowed opacity-50': meta.current_page >= meta.last_page }">
                Next
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, reactive } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import ItemCard from "./ItemCard.vue";

defineOptions({ layout: AppLayout });

const props = defineProps<{
  items: any[];
  meta: { current_page: number; last_page: number; per_page: number; total: number };
  seo: Record<string, any>;
  categories: any[];
  brands: any[];
  selectedFilters: Record<string, string | number | null | undefined>;
  category: any | null;
  subCategory: any | null;
}>();

const seo = props.seo;

const filters = reactive({
  q: props.selectedFilters.q ?? "",
  brand_slug: props.selectedFilters.brand_slug ?? "",
  per_page: props.selectedFilters.per_page ?? 12,
});

const pageTitle = computed(() => {
  if (props.subCategory) {
    return props.subCategory.name;
  }

  if (props.category) {
    return props.category.name;
  }

  return "All Equipment";
});

const pageSubtitle = computed(() => {
  if (props.subCategory) {
    return props.subCategory.description || seo.description;
  }

  if (props.category) {
    return props.category.description || seo.description;
  }

  return seo.description;
});

const basePath = computed(() => {
  if (props.subCategory && props.category) {
    return `/equipment/${props.category.slug}/${props.subCategory.slug}`;
  }

  if (props.category) {
    return `/equipment/${props.category.slug}`;
  }

  return "/items";
});

function buildUrl(overrides: Record<string, string | number | null | undefined> = {}) {
  const params = new URLSearchParams();
  const combined = {
    ...props.selectedFilters,
    ...filters,
    ...overrides,
  };

  Object.entries(combined).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== "") {
      params.set(key, String(value));
    }
  });

  return `${basePath.value}${params.toString() ? `?${params.toString()}` : ""}`;
}

function pageUrl(page: number) {
  return buildUrl({ page: Math.max(1, page) });
}

function submitFilters() {
  window.location.href = buildUrl({ page: 1 });
}

function resetFilters() {
  filters.q = "";
  filters.brand_slug = "";
  window.location.href = basePath.value;
}
</script>
