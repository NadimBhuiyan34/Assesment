<template>

  <section class="py-16 px-4 bg-gray-100 my-5 shadow-lg">
    <div class=" mx-auto">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-dark mb-12">
        Shop by <span class="text-blue-500">Category</span>
      </h2>

      <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-5">
        <Link v-for="cat in categories" :key="cat.name" href=""
          class="group flex flex-col items-center justify-center bg-white border border-gray-200 hover:border-blue-500 shadow-sm hover:shadow-md rounded-xl p-4 transition-all duration-300">
        <div
          class="w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full bg-blue-50 group-hover:bg-blue-100 transition">

        </div>
        <h3 class="mt-3 text-sm sm:text-base font-medium text-gray-700 group-hover:text-blue-600 text-center">
          {{ cat.name }}
        </h3>
        </Link>
      </div>
    </div>
  </section>

</template>

<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const categories = computed(() => page.props.categories ?? []);


</script>
