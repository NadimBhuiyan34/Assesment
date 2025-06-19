<script setup lang="ts">
import { ref, defineProps } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
  product: {
    id: string;
    name: string;
    images: {
      id: string;
      image_path: string;
      is_featured: boolean;
    }[];
  };
}>();

const selectedFile = ref<File | null>(null);
const previewUrl = ref<string | null>(null);
const isFeatured = ref(false);
const isSubmitting = ref(false);
const errors = ref<{ image?: string }>({});

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  errors.value.image = '';

  if (target.files && target.files.length > 0) {
    const file = target.files[0];

    // Frontend validation
    if (!file.type.startsWith('image/')) {
      errors.value.image = 'Only image files are allowed.';
      selectedFile.value = null;
      return;
    }

    if (file.size > 2 * 1024 * 1024) {
      errors.value.image = 'Image size must be less than 2MB.';
      selectedFile.value = null;
      return;
    }

    selectedFile.value = file;
    previewUrl.value = URL.createObjectURL(file);
  } else {
    selectedFile.value = null;
    previewUrl.value = null;
  }
};

const submitForm = () => {
  errors.value.image = '';

  if (!selectedFile.value) {
    errors.value.image = 'Please select an image.';
    return;
  }

  isSubmitting.value = true;

  const formData = new FormData();
  formData.append('image', selectedFile.value);
  formData.append('is_featured', isFeatured.value ? '1' : '0');
  formData.append('product_id', props.product.id);

  router.post('/product_images', formData, {
    forceFormData: true,
    preserveScroll: true,
    onError: (backendErrors) => {
      errors.value.image = backendErrors.image;
    },
    onFinish: () => {
      isSubmitting.value = false;
    },
    onSuccess: () => {
      selectedFile.value = null;
      previewUrl.value = null;
      isFeatured.value = false;
    }
  });
};

const deleteImage = (id: string) => {
  if (!confirm('Are you sure you want to delete this image?')) return;

  router.delete(`/product_images/${id}`, {
    preserveScroll: true,
    onError: (errors) => {
      alert('Failed to delete image.');
      console.error(errors);
    },
  });
};
</script>

<template>
  <Head :title="`Upload Image • ${props.product.name}`" />
  <AppLayout :breadcrumbs="[
    { title: 'Products', href: '/products' },
    { title: 'Upload Image', href: '#' }
  ]">
    <!-- Upload Form -->
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8 mt-12">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">
        Upload Image for <span class="text-indigo-600">{{ props.product.name }}</span>
      </h2>

      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- File Input -->
        <div>
          <label for="image" class="block font-medium text-gray-700 mb-2">Choose Image</label>
          <input
            type="file"
            id="image"
            accept="image/*"
            @change="handleFileChange"
            class="w-full border rounded-md px-3 py-2 text-gray-800 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
          />
          <p v-if="errors.image" class="text-red-600 text-sm mt-1">{{ errors.image }}</p>

          <div v-if="previewUrl" class="mt-4 border rounded-md overflow-hidden max-h-64">
            <img :src="previewUrl" alt="Image preview" class="w-full h-full object-contain" />
          </div>
        </div>

        <!-- Featured Checkbox -->
        <div class="flex items-center space-x-2">
          <input
            type="checkbox"
            id="featured"
            v-model="isFeatured"
            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
          />
          <label for="featured" class="text-gray-700 font-medium cursor-pointer">Set as featured image</label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="isSubmitting"
          class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 disabled:bg-indigo-300 disabled:cursor-not-allowed transition"
        >
          {{ isSubmitting ? 'Uploading...' : 'Upload Image' }}
        </button>
      </form>
    </div>

    <!-- Uploaded Images Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-10">
      <div
        v-for="image in props.product.images"
        :key="image.id"
        class="group relative bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition"
      >
        <img
          :src="`/storage/${image.image_path}`"
          :alt="props.product.name"
          class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105"
        />

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity"></div>

        <!-- Featured Badge -->
        <div
          v-if="image.is_featured"
          class="absolute top-3 left-3 bg-indigo-600 text-white text-xs px-3 py-1 rounded-full shadow"
        >
          🌟 Featured
        </div>

        <!-- Delete Button -->
        <Link
          as="button"
          :href="`/product_images/${image.id}`"
          @click.prevent="deleteImage(image.id)"
          class="absolute top-3 right-3 bg-white/90 hover:bg-white text-red-600 hover:text-red-800 rounded-full p-2 shadow transition focus:outline-none focus:ring-2 focus:ring-red-500"
          title="Delete Image"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="sr-only">Delete</span>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
