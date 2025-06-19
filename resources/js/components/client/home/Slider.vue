<template>
  <div class="relative w-full max-w-[1550px] mx-auto overflow-hidden   select-none mb-5 ">
    <!-- Slide container -->
    <div class="relative h-[400px] md:h-[500px]">
      <transition-group
        name="slide-fade"
        tag="div"
        class="relative h-full"
      >
        <div
          v-for="(slide, idx) in sliders"
          :key="slide.id || idx"
          v-show="idx === activeIndex"
          class="absolute inset-0 w-full h-full flex flex-col md:flex-row items-center md:items-start justify-center md:justify-between bg-black"
          aria-live="polite"
        >
          <!-- Image -->
          <img
            :src="slide.image"
            alt="Slide Image"
            class="absolute inset-0 w-full h-full  object-cover brightness-75 transition-transform duration-700 ease-in-out hover:scale-100"
            draggable="false"
          />

          <!-- Overlay content -->
          <div
            class="relative z-10 px-6 md:px-16 py-12 md:py-24 max-w-xl text-white drop-shadow-lg h-full mx-auto"
          >
            <h2 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">
              {{ slide.name }}
            </h2>
            <p class="text-lg md:text-xl mb-6 max-w-lg">
              {{ slide.description }}
            </p>
            
           
          </div>
        </div>
      </transition-group>

      <!-- Navigation arrows -->
      <button
        @click="prevSlide"
        aria-label="Previous Slide"
        class="absolute top-1/2 left-4 md:left-8 -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-3 rounded-full shadow-lg transition z-20"
      >
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          viewBox="0 0 24 24"
        >
          <path d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <button
        @click="nextSlide"
        aria-label="Next Slide"
        class="absolute top-1/2 right-4 md:right-8 -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-3 rounded-full shadow-lg transition z-20"
      >
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          viewBox="0 0 24 24"
        >
          <path d="M9 5l7 7-7 7"></path>
        </svg>
      </button>

      <!-- Slide indicators -->
      <div
        class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-4 z-20"
      >
        <button
          v-for="(slide, idx) in sliders"
          :key="'indicator-' + idx"
          @click="goToSlide(idx)"
          :class="[
            'w-4 h-4 rounded-full border-2 border-white transition-colors',
            idx === activeIndex ? 'bg-indigo-500 border-indigo-500' : 'bg-transparent hover:bg-indigo-400 hover:border-indigo-400'
          ]"
          :aria-label="'Go to slide ' + (idx + 1)"
        ></button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3';
const props = defineProps({
  sliders: {
    type: Array,
    required: true,
  },
})

const activeIndex = ref(0)
let slideInterval = null

function nextSlide() {
  activeIndex.value = (activeIndex.value + 1) % props.sliders.length
}
function prevSlide() {
  activeIndex.value = (activeIndex.value - 1 + props.sliders.length) % props.sliders.length
}
function goToSlide(index) {
  activeIndex.value = index
}
function startAutoSlide() {
  slideInterval = setInterval(nextSlide, 6000)
}
onMounted(startAutoSlide)
onBeforeUnmount(() => slideInterval && clearInterval(slideInterval))
</script>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 0.6s ease, transform 0.6s ease;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(20px);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
