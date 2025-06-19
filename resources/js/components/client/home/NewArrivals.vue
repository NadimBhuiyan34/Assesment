<!-- NewArrivals.vue -->
<template>
  <section class="py-20 bg-white px-6 my-5  ">
    <div class=" mx-auto">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">🆕 New Arrivals</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="item in arrivals"
          :key="item.id"
          class="bg-gray-50 border rounded-xl overflow-hidden shadow hover:shadow-lg transition"
        >
          <img :src="item.image" :alt="item.name" class="w-full h-48 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ item.name }}</h3>
            <p class="text-blue-600 font-bold">{{ item.price }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({ arrivals: Array })
</script>
