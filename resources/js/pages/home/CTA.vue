<template>
  <section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
      <!-- Title -->
      <h2 class="text-3xl md:text-4xl font-bold mb-4">
        Ready to launch your project?
      </h2>

      <!-- Subtitle -->
      <p class="text-lg md:text-xl text-gray-300 mb-8">
        We provide all the filming and lighting equipment you need with top quality and competitive prices.
      </p>

      <!-- Buttons -->
      <div class="flex flex-col md:flex-row justify-center gap-4">
       <router-link
          :to="'/contact'"
          class="border border-yellow-500 hover:bg-yellow-500 hover:text-black font-semibold px-8 py-3 rounded-2xl transition duration-300"
        >
          Contact Us
        </router-link>

        <router-link
          :to="'/makequotation'"
          class="border border-yellow-500 hover:bg-yellow-500 hover:text-black font-semibold px-8 py-3 rounded-2xl transition duration-300"
        >
          Make A Quotation
        </router-link>
      </div>

      
    </div>
  </section>
</template>

<script setup>
// No logic needed, simple display component
</script>
