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

  <section class="pt-32 pb-16 bg-primary/5 min-h-screen">
    <div class="container mx-auto px-6">
      <div class="mb-8 space-y-3">
        <h1 class="text-4xl font-bold text-primary">Equipment Catalog</h1>
        <p class="max-w-3xl text-lg text-secondary">{{ seo.description }}</p>
      </div>

      <div class="grid gap-6 lg:grid-cols-[300px_1fr]">
        <aside class="space-y-6">
          <div class="rounded-3xl border border-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-primary mb-4">Filter equipment</h2>

            <form @submit.prevent="submitFilters" class="space-y-4">
              <div>
                <label class="mb-2 block text-sm font-medium text-secondary">Search</label>
                <input
                  v-model="filters.q"
                  type="search"
                  placeholder="Search gear, brand or category"
                  class="w-full rounded-2xl border border-primary/20 bg-slate-50 px-4 py-3 text-sm text-secondary outline-none transition focus:border-primary"
                />
              </div>

              <div>
                <label class="mb-2 block text-sm font-medium text-secondary">Category</label>
                <select v-model="filters.category_slug" class="w-full rounded-2xl border border-primary/20 bg-slate-50 px-4 py-3 text-sm text-secondary outline-none">
                  <option value="">All categories</option>
                  <option v-for="category in categories" :key="category.id" :value="category.slug">
                    {{ category.name }}
                  </option>
                </select>
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
                  Apply filters
                </button>
                <button type="button" @click="resetFilters" class="text-sm text-secondary underline underline-offset-2">
                  Reset
                </button>
              </div>
            </form>
          </div>

          <div class="rounded-3xl border border-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-primary mb-4">Popular brands</h2>
            <div class="space-y-2">
              <button
                v-for="brand in brands.slice(0, 8)"
                :key="brand.id"
                @click="selectBrand(brand.slug)"
                class="block w-full rounded-2xl border border-primary/10 bg-slate-50 px-4 py-3 text-left text-sm text-secondary transition hover:bg-primary hover:text-white"
              >
                {{ brand.name }}
              </button>
            </div>
          </div>
        </aside>

        <div class="space-y-6">
          <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <ItemCard v-for="item in items" :key="item.id" :item="item" />
          </div>

          <div v-if="items.length === 0" class="rounded-3xl border border-primary/10 bg-white p-10 text-center text-lg text-secondary shadow-sm">
            No equipment matches your filters.
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
import { reactive } from "vue";
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
}>();

const seo = props.seo;

const filters = reactive({
  q: props.selectedFilters.q ?? "",
  main_category_slug: props.selectedFilters.main_category_slug ?? "",
  category_slug: props.selectedFilters.category_slug ?? "",
  sub_category_slug: props.selectedFilters.sub_category_slug ?? "",
  brand_slug: props.selectedFilters.brand_slug ?? "",
  per_page: props.selectedFilters.per_page ?? 12,
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

  return `/items${params.toString() ? `?${params.toString()}` : ""}`;
}

function pageUrl(page: number) {
  return buildUrl({ page: Math.max(1, page) });
}

function submitFilters() {
  window.location.href = buildUrl({ page: 1 });
}

function resetFilters() {
  filters.q = "";
  filters.category_slug = "";
  filters.brand_slug = "";
  filters.sub_category_slug = "";
  filters.main_category_slug = "";
  window.location.href = "/items";
}

function selectBrand(slug: string) {
  filters.brand_slug = slug;
  window.location.href = buildUrl({ page: 1 });
}
</script>
