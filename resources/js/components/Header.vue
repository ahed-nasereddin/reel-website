<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed, onBeforeUnmount } from "vue";
import { Motion } from "motion-v";
import { Link, usePage } from "@inertiajs/vue3";
import CartIcon from '@/components/CartIcon.vue';
import CartDropdown from '@/components/CartDropdown.vue';
import { useCart } from '@/composables/useCart';
import axios from 'axios';
import { MainCategory } from '@/types';
const categories = ref<MainCategory[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);
const equipmentOpen = ref(false);
const fetchCategories = async () => {
    console.log('Fetching categories...');
    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data.data || response.data;
        console.log('Categories fetched:', categories.value);
    } catch (err) {
        error.value = 'Failed to load categories. Please try again later.';
        console.error('Error fetching categories:', err);
    } finally {
        console.log('Categories fetched:', categories.value);
        loading.value = false;
    }
};


const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    initializeCart();
    fetchCategories();
});


const open = ref(false);
const cartOpen = ref(false);
const page = usePage();

const { initializeCart, totalItems } = useCart();

const currentPath = computed(() => page.url);


const isHome = computed(() => currentPath.value === "/");

function onEscKey(event: KeyboardEvent) {
    if (event.key === "Escape") {
        open.value = false;
    }
}

const navItems = [
    { label: "Home", to: "/" },
    //{ label: "Contact", to: "/contact" },
    { label: "Projects", to: "/projects" },
    // { label: "Make a Quotation", to: "/Quotation" },
];

onMounted(() => window.addEventListener("keydown", onEscKey));
onBeforeUnmount(() => window.removeEventListener("keydown", onEscKey));
</script>

<template>
    <header :class="[
        isHome
            ? 'absolute text-white w-full top-0 left-0 px-2 flex justify-between items-center z-50 transition-colors duration-300'
            : 'fixed z-30 bg-gradient-to-b from-accent via-accent to-accent flex justify-between items-center px-2 mb-2 w-full text-secondary border-b-2 border-primary shadow-md',
        isHome && isScrolled
            ? 'bg-gradient-to-t from-accent via-accent to-accent fixed text-secondary shadow-md'
            : '',
    ]">
        <div class="flex justify-center">
            <img v-if="isHome && !isScrolled" src="/images/logo-white.png" alt="ReelQuip Films Logo"
                class="h-32 w-auto object-contain" />
            <img v-else src="/images/logo-black.png" alt="ReelQuip Films Logo" class="h-28 w-auto object-contain" />
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center space-x-6">
            <div class="relative" @mouseenter="equipmentOpen = true" @mouseleave="equipmentOpen = false">
                <button class="flex items-center gap-2 p-2 font-bold transition-all hover:bg-accent
         hover:text-primary hover:rounded-xl "
                    :class="{ 'text-primary': equipmentOpen, 'text-accent': !equipmentOpen && isHome ,'text-secondary': !equipmentOpen && !isHome || (isScrolled && isHome) }">
                    Equipment

                    <svg class="h-4 w-4 transition" :class="{ 'rotate-180': equipmentOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <transition enter-active-class="transition duration-200" enter-from-class="opacity-0 translate-y-2"
                    enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <div v-if="equipmentOpen"
                        class="absolute left-0 top-full z-50 mt-3 w-[400px] rounded-3xl border border-primary/10 bg-white p-8 shadow-2xl">
                        <div v-if="loading" class="text-center py-10 text-secondary">
                            Loading categories...
                        </div>

                        <div v-else class="grid grid-cols-1 gap-8">
                            <div v-for="mainCategory in categories" :key="mainCategory.id">
                                <h3 class="mb-4 border-b border-primary/10 pb-2 font-bold text-primary">
                                    {{ mainCategory.name }}
                                </h3>

                                <div class="space-y-2">
                                    <Link v-for="subCategory in mainCategory.sub_categories" :key="subCategory.id"
                                        :href="`/equipment/${mainCategory.slug}/${subCategory.slug}`"
                                        class="block rounded-xl px-3 py-2 text-sm text-secondary transition hover:bg-primary hover:text-white">
                                        {{ subCategory.name }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>

            <Motion v-for="(item, index) in navItems" :key="index" :whileHover="{ scale: 1.09 }"
                :transition="{ type: 'spring', stiffness: 300 }">
                <Link :href="item.to" :class="[
                    'block hover:scale-105 p-2 font-bold hover:font-bold text-accent hover:bg-accent hover:text-primary hover:rounded-xl cursor-pointer transition-all',
                    {
                        'bg-accent text-primary rounded-xl':
                            currentPath === item.to,
                        'text-secondary hover:bg-accent hover:text-primary':
                            isScrolled && isHome && currentPath !== item.to,
                        'text-secondary hover:text-primary':
                            !isHome && currentPath !== item.to,
                    },
                ]">
                    {{ item.label }}
                </Link>
            </Motion>
        </nav>

        <div class="flex items-center gap-4">
            <CartIcon :count="totalItems" @toggle="cartOpen = !cartOpen" />
        </div>

        <CartDropdown :open="cartOpen" @close="cartOpen = false" />

        <!-- Mobile Menu -->
        <button @click="open = !open" aria-label="Toggle menu" :aria-expanded="open"
            class="md:hidden bg-primary rounded-lg p-2 focus:outline-none">
            <svg v-if="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Sidebar Mobile Nav -->
        <transition name="slide-fade">
            <nav v-if="open"
                class="fixed z-50 top-0 left-0 h-full w-64 bg-white border-l-2 border-primary p-6 space-y-6 shadow-lg overflow-auto"
                role="dialog" aria-modal="true" aria-label="Mobile Navigation Menu">
                <button @click="open = false" aria-label="Close menu" class="text-primary mb-4 focus:outline-none">
                    Close ✕
                </button>

                <nav class="grid space-y-6">
                    <div>
                        <button @click="equipmentOpen = !equipmentOpen"
                            class="flex w-full items-center justify-between rounded-xl p-2 text-primary font-bold">
                            Equipment

                            <svg class="h-4 w-4 transition" :class="{ 'rotate-180': equipmentOpen }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div v-if="equipmentOpen" class="mt-4 space-y-4 pl-4">
                            <div v-for="mainCategory in categories" :key="mainCategory.id">
                                <div class="font-bold text-primary mb-2">
                                    {{ mainCategory.name }}
                                </div>

                                <div class="space-y-2">
                                    <Link v-for="subCategory in mainCategory.sub_categories" :key="subCategory.id"
                                        :href="`/equipment/${mainCategory.slug}/${subCategory.slug}`"
                                        @click="open = false"
                                        class="block rounded-lg px-3 py-2 text-secondary hover:bg-primary hover:text-white">
                                        {{ subCategory.name }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Link v-for="(item, index) in navItems" :key="index" :href="item.to" @click="open = false" :class="{
                        'bg-primary text-white rounded-xl': currentPath === item.to,
                    }"
                        class="block text-primary hover:bg-primary hover:text-white hover:scale-105 p-2 hover:font-bold hover:rounded-xl cursor-pointer transition-all">
                        {{ item.label }}
                    </Link>

                </nav>
            </nav>
        </transition>

        <!-- Overlay -->
        <transition name="fade">
            <div v-if="open" @click="open = false" class="fixed z-30 inset-0 bg-white/40 backdrop-blur-sm bg-opacity-50"
                aria-hidden="true"></div>
        </transition>
    </header>
</template>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}

.slide-fade-enter-to,
.slide-fade-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}
</style>
