<!-- NewsletterSignup.vue -->
<template>
  <section class="py-20 bg-blue-50 px-6 my-5 ">
    <div class=" mx-auto text-center">
      <h2 class="text-3xl font-bold text-blue-700 mb-4">📬 Join Our Newsletter</h2>
      <p class="text-gray-600 mb-6">Stay updated with our latest offers and products.</p>

      <form @submit.prevent="submit" class="flex flex-col sm:flex-row gap-4">
        <input
          v-model="email"
          type="email"
          placeholder="Enter your email"
          class="flex-1 px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
          required
        />
        <button
          type="submit"
          class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition"
        >
          Subscribe
        </button>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
const email = ref('')

const submit = () => {
  // send to API or show a success toast
  alert(`Subscribed: ${email.value}`)
  email.value = ''
}
</script>
