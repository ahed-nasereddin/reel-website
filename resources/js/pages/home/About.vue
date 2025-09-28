<template>
  <section class="py-16 bg-gradient-to-b from-white via-primary/5 to-white">
  <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row items-center gap-12">
    
    <!-- Text Content -->
    <div class="lg:w-1/2">
      <h2 class="text-3xl md:text-4xl font-bold text-primary mb-6">About Us</h2>
      <p class="text-secondary mb-4 leading-relaxed">
        We are a professional production rental company providing high-quality lighting, camera, and grip equipment. 
        Our experienced crew ensures smooth operations on every project, from commercials to feature films.
      </p>
      <p class="text-secondary mb-6 leading-relaxed">
        Our mission is to provide reliable, cutting-edge production equipment and professional crew services 
        to make your vision come to life. We pride ourselves on excellent customer service, timely delivery, 
        and technical expertise.
      </p>

      <!-- Features -->
      <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-secondary font-medium">
        <li 
          v-for="(feature,index) in features" 
          :key="index" 
          class="flex items-start space-x-2"
        > 
          <svg xmlns="http://www.w3.org/2000/svg" 
               viewBox="0 0 24 24" 
               fill="currentColor" 
               class="w-6 h-6 text-primary shrink-0 mt-1">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 
            9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 
            9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 
            0 1 0-1.22-.872l-3.236 4.53L9.53 
            12.22a.75.75 0 0 0-1.06 
            1.06l2.25 2.25a.75.75 0 0 0 
            1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
          </svg>
          <span>{{ feature }}</span>
        </li>
      </ul>
    </div>

    <!-- Image -->
    <div class="lg:w-1/2">
      <img
        src="storage/images/about-us.jpg"
        alt="About Us"
        class="rounded-2xl shadow-xl w-full object-cover border-2 border-primary/20"
      />
    </div>

  </div>
</section>

</template>

<script setup>
// No script needed unless you want dynamic data
const features = [
  "Professional Lighting & Grip Equipment",
  "Experienced Crew: Gaffer, Best Boy, Sparks",
  "Camera Rentals & Accessories",
  "On-Set Support & Consultation"
];

</script>

<style scoped>
/* optional: animate image on hover */
img:hover {
  transform: scale(1.02);
  transition: transform 0.5s ease-in-out;
}
</style>
