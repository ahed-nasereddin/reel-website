<template>
  <section class="bg-gradient-to-b from-accent via-accent to-primary/30 border-b-1 border-t-1 border-secondary text-primary py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
      <!-- Title -->
      <h2 class="text-3xl md:text-4xl text-secondary font-bold mb-4">
        Ready to launch your project?
      </h2>

      <!-- Subtitle -->
      <p class="text-lg md:text-xl text-secondary/80 mb-8">
        We provide all the filming and lighting equipment you need with top quality and competitive prices.
      </p>

      <!-- Buttons -->
      <div class="flex flex-col md:flex-row justify-center gap-4">
        <Link
          :href="'/contact'"
          class="border border-primary hover:bg-primary hover:text-black font-semibold px-8 py-3 rounded-2xl transition duration-300"
        >
          Contact Us
        </Link>

        <Link
          :href="'/Quotation'"
          class="border border-primary hover:bg-primary hover:text-black font-semibold px-8 py-3 rounded-2xl transition duration-300"
        >
          Make A Quotation
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

// No logic needed
</script>
