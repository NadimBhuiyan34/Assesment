<script setup lang="ts">
import Header from '@/components/client/layouts/Header.vue'
import Footer from '@/components/client/layouts/Footer.vue'
 
import { defineProps, ref, watch } from 'vue'

 

 
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <Header />

    <!-- Page Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>
