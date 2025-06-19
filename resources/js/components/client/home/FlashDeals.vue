<!-- FlashDeals.vue -->
<template>
  <section class="py-20 bg-gradient-to-r from-yellow-100 to-red-100 px-6 my-5 ">
    <div class=" mx-auto text-center">
      <h2 class="text-3xl font-extrabold text-red-600 mb-6">⚡ Flash Deals</h2>
      <p class="text-gray-700 mb-10 text-lg">Hurry! These deals won’t last long.</p>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div
          v-for="deal in deals"
          :key="deal.id"
          class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition"
        >
          <img :src="deal.image" class="h-40 w-full object-cover rounded-md mb-4" />
          <h3 class="font-semibold text-gray-800 text-lg mb-2">{{ deal.name }}</h3>
          <p class="text-sm text-gray-500 line-clamp-2">{{ deal.description }}</p>
          <div class="flex items-center justify-between mt-4">
            <span class="text-red-600 font-bold">{{ deal.price }}</span>
            <button class="bg-red-600 text-white px-4 py-1 text-sm rounded-full hover:bg-red-700 transition">Grab</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({ deals: Array })
</script>
