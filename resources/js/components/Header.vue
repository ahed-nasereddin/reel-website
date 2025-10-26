<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed, onBeforeUnmount, watch } from "vue";
import { Motion } from "motion-v";
import { useRoute } from "vue-router";

const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50; // trigger after 50px scroll
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const open = ref(false);
const route = useRoute();





const isHome = computed(() => route.path === "/");

// import { createRouter } from 'vue-router'
function onEscKey(event: KeyboardEvent) {
    if (event.key === "Escape") {
        open.value = false;
    }
}

const navItems = [
    { label: "Home", to: "/" },
    { label: "Contact", to: "/contact" },
    { label: "Projects", to: "/projects" },
    { label: "Make a Quotation", to: "/makequotation" },
];

onMounted(() => window.addEventListener("keydown", onEscKey));
onBeforeUnmount(() => window.removeEventListener("keydown", onEscKey));

</script>

<template>
    <header
        :class="[
            // Base: different for home vs other pages
            isHome
                ? 'absolute  text-white w-full top-0 left-0  px-2 flex justify-between items-center z-50 transition-colors duration-300'
                : 'fixed z-10 bg-gradient-to-b from-accent via-accent  to-accent flex justify-between items-center px-2 mb-2 w-full text-secondary border-b-2 border-primary shadow-md',

            // Scroll effect: only when on home
            isHome && isScrolled
                ? 'bg-gradient-to-t from-accent via-accent to-accent fixed text-secondary shadow-md '
                : '',
        ]"
    >
        <div class="flex justify-center ">
            <img
                src="/images/logo.png"
                alt="ReelQuip Films Logo"
                class="h-28  w-auto object-contain"
            />
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex space-x-6">
            <Motion
                v-for="(item, index) in navItems"
                :key="index"
                :whileHover="{ scale: 1.09 }"
                :transition="{ type: 'spring', stiffness: 300 }"
            >
                <router-link
                    :to="item.to"
                    :class="[
                        'block hover:scale-105 p-2 font-bold hover:font-bold text-accent  hover:bg-accent hover:text-primary hover:rounded-xl cursor-pointer transition-all',
                        {
                            'bg-accent text-primary rounded-xl':
                                $route.path === item.to,
                            'text-secondary hover:bg-accent hover:text-primary':
                                isScrolled && isHome &&$route.path !== item.to ,
                            'text-secondary  hover:text-primary':
                                !isHome && $route.path !== item.to, 

                        },
                    ]"
                >
                    {{item.label }}  
                </router-link>
            </Motion>
        </nav>
        <!-- Mobile menu button -->
        <button
            @click="open = !open"
            aria-label="Toggle menu"
            :aria-expanded="open"
            class="md:hidden bg-primary rounded-lg p-2 focus:outline-none"
        >
            <svg
                v-if="!open"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>

        <!-- Sidebar Mobile Nav -->
        <transition name="slide-fade">
            <nav
                v-if="open==true"
                class="fixed z-50 top-0 left-0 h-full w-64 bg-white border-l-2 border-primary p-6 space-y-6 shadow-lg overflow-auto"
                role="dialog"
                aria-modal="true"
                aria-label="Mobile Navigation Menu"
            >
                <button
                    @click="open = false"
                    aria-label="Close menu"
                    class="text-primary mb-4 focus:outline-none"
                >
                    Close ✕
                </button>

                <nav class="grid space-y-6">
                    <router-link
                        v-for="(item, index) in navItems"
                        :key="index"
                        :to="item.to"
                        @click="open=false"
                        :class="{
                            'bg-primary text-white rounded-xl':
                                $route.path === item.to,
                        }"
                        class="block text-primary hover:bg-primary hover:text-white hover:scale-105 p-2 hover:font-bold hover:rounded-xl cursor-pointer transition-all"
                    >
                        {{ item.label }}
                    </router-link>
                </nav>
            </nav>
        </transition>

        <!-- Overlay -->
        <transition name="fade">
            <div
                v-if="open"
                @click="open = false"
                class="fixed z-30 inset-0 bg-white/40 backdrop-blur-sm bg-opacity-50"
                aria-hidden="true"
            ></div>
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
