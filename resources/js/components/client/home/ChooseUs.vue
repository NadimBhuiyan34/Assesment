<!-- WhyChooseUs.vue -->
<template>
  <section class="py-20 bg-gray-100 px-6 my-5 ">
    <div class=" mx-auto text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-10">💡 Why Choose Us</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div v-for="(feature, index) in features" :key="index" class="p-6 bg-white rounded-xl shadow hover:shadow-md transition">
          <div class="text-blue-600 text-4xl mb-4">{{ feature.icon }}</div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ feature.title }}</h3>
          <p class="text-gray-600 text-sm">{{ feature.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  features: Array, // Example: [{ icon: '🚚', title: 'Free Shipping', description: 'On all orders over $50' }]
})
</script>
