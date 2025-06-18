<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { Undo2 } from 'lucide-vue-next';
import type { BreadcrumbItem } from '@/types';

interface Category {
  id: string;
  name: string;
  description: string;
  status: boolean;
  slug: string;
  parent_id?: string | null;
}

const props = defineProps<{
  categories: Category[];
}>();

const form = useForm({
  name: '',
  description: '',
  parent_id: '',
  image: '',
  status: true,
});

const submit = () => {
  form.post('/categories');
};

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Category Create', href: '/categories' },
];
</script>

<template>
  <Head title="Create Category" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 w-full h-full mx-auto bg-gray-100 rounded shadow">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Category</h1>

      <form @submit.prevent="submit" class="space-y-5 bg-white p-6 rounded-xl shadow-md">
        <!-- Name -->
        <div>
          <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
          <input id="name" v-model="form.name" type="text"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
          <textarea id="description" v-model="form.description" rows="4"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
          <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <!-- Parent Category -->
        <div>
          <label for="parent_id" class="block text-gray-700 font-medium mb-1">Parent Category</label>
          <select id="parent_id" v-model="form.parent_id"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">-- None (Main Category) --</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
          <p v-if="form.errors.parent_id" class="text-red-600 text-sm mt-1">{{ form.errors.parent_id }}</p>
        </div>

        <!-- Status -->
        <div class="flex items-center">
          <input id="status" v-model="form.status" type="checkbox" class="mr-2" />
          <label for="status" class="text-gray-700">Active</label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3 mt-4">
          <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
            :disabled="form.processing">
            Save
          </button>
          <Link href="/categories"
            class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
            <Undo2 class="w-4 h-4 mr-1" /> Back
          </Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
