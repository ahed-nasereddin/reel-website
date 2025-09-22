<template>
  <section class="py-16 bg-white">
    <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row items-center gap-12">
      
      <!-- Text Content -->
      <div class="lg:w-1/2">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">About Us</h2>
        <p class="text-gray-600 mb-4">
          We are a professional production rental company providing high-quality lighting, camera, and grip equipment. Our experienced crew ensures smooth operations on every project, from commercials to feature films.
        </p>
        <p class="text-gray-600 mb-6">
          Our mission is to provide reliable, cutting-edge production equipment and professional crew services to make your vision come to life. We pride ourselves on excellent customer service, timely delivery, and technical expertise.
        </p>
        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
          <li>✅ Professional Lighting & Grip Equipment</li>
          <li>✅ Experienced Crew: Gaffer, Best Boy, Sparks</li>
          <li>✅ Camera Rentals & Accessories</li>
          <li>✅ On-Set Support & Consultation</li>
        </ul>
      </div>

      <!-- Image -->
      <div class="lg:w-1/2">
        <img
          src="storage/images/about-us.jpg"
          alt="About Us"
          class="rounded-2xl shadow-lg w-full object-cover"
        />
      </div>

    </div>
  </section>
</template>

<script setup>
// No script needed unless you want dynamic data
</script>

<style scoped>
/* optional: animate image on hover */
img:hover {
  transform: scale(1.02);
  transition: transform 0.5s ease-in-out;
}
</style>
