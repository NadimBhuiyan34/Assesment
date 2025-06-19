<!-- Testimonials.vue -->
<template>
  <section class="py-20 bg-white px-6 my-5">
    <div class="mx-auto text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-12">🌟 What Our Customers Say</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div
          v-for="(review, index) in testimonials"
          :key="index"
          class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition"
        >
          <p class="text-sm text-gray-600 mb-4">“{{ review.message }}”</p>
          <div class="font-semibold text-blue-600">{{ review.name }}</div>
          <div class="text-xs text-gray-400">{{ review.role }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  testimonials: Array, // [{ name: 'John Doe', message: 'Awesome service!', role: 'Customer' }]
})
</script>
