<template>
  <Transition name="fade">
    <div
      v-if="visible"
      class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4"
    >
      <div
        :class="[
          'flex items-start gap-3 p-4 rounded-md shadow-lg border text-sm',
          type === 'success' && 'bg-green-100 border-green-300 text-green-800',
          type === 'error' && 'bg-red-100 border-red-300 text-red-800',
          type === 'warning' && 'bg-yellow-100 border-yellow-300 text-yellow-800',
          type === 'info' && 'bg-blue-100 border-blue-300 text-blue-800'
        ]"
      >
        <div class="flex-1">
          {{ message }}
        </div>
        <button @click="visible = false" class="text-xl leading-none focus:outline-none">
          &times;
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const flash = page.props.flash

const message = ref<string | null>(null)
const type = ref<'success' | 'error' | 'warning' | 'info' | null>(null)
const visible = ref(false)

watch(
  () => flash,
  () => {
    if (flash.success) {
      type.value = 'success'
      message.value = flash.success
    } else if (flash.error) {
      type.value = 'error'
      message.value = flash.error
    } else if (flash.warning) {
      type.value = 'warning'
      message.value = flash.warning
    } else if (flash.info) {
      type.value = 'info'
      message.value = flash.info
    } else {
      message.value = null
      type.value = null
    }

    if (message.value) {
      visible.value = true
      setTimeout(() => {
        visible.value = false
      }, 3000)
    }
  },
  { immediate: true, deep: true }
)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
