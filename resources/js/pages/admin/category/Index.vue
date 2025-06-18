<script setup lang="ts">
import { ref, watch, defineProps } from 'vue'
import { router, Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Trash2, PenLine } from 'lucide-vue-next'

// Define Category interface
interface Category {
  id: string
  name: string
  description: string
  status: boolean
  slug: string
  category_parent?: {
    id: string
    name: string
  } | null
}

// Props
const props = defineProps<{
  categories: {
    data: Category[]
    current_page: number
    last_page: number
    total: number
    from: number
    to: number
  }
  filters: { search?: string }
}>()

// State
const search = ref(props.filters?.search || '')
const isLoading = ref(false)

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Category', href: '/categories' },
]

// Watch search input and fetch filtered data
watch(
  search,
  async (value) => {
    isLoading.value = true
    await router.get(
      '/categories',
      { search: value },
      {
        preserveState: true,
        replace: true,
        onFinish: () => (isLoading.value = false),
      }
    )
  },
  { immediate: true }
)


const deleteCategory = (slug: string) => {
  if (confirm('Are you sure you want to delete this category?')) {
    router.delete(`/categories/${slug}`, {
      preserveScroll: true,
      onSuccess: () => {
        alert('✅ Category deleted successfully!')
      },
      onError: () => {
        alert('❌ Failed to delete category.')
      }
    })
  }
}


// Handle pagination
const handlePaginate = (page: number) => {
  router.get(
    '/categories',
    { search: search.value, page },
    {
      preserveState: true,
      replace: true,
    }
  )
}
</script>

<template>

  <Head title="Category" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 sm:p-6 w-full h-full mx-auto space-y-6 bg-gray-100">

      <!-- Header -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Categories</h1>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
          <input v-model="search" type="text" placeholder="Search by name..."
            class="w-full sm:w-64 px-4 py-2 border rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <Link href="/categories/create"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
          + Add New Category
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Description</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Parent</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
              <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="category in props.categories.data" :key="category.id" class="hover:bg-gray-50 transition">
              <td class="px-4 py-3">{{ category.name }}</td>
              <td class="px-4 py-3">{{ category.description }}</td>
              <td class="px-4 py-3">
                {{ category.category_parent?.name ?? 'Root' }}
              </td>
              <td class="px-4 py-3">
                <span :class="category.status ? 'text-green-600' : 'text-red-500'" class="font-medium">
                  {{ category.status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-4 py-3 text-right flex justify-end gap-2">
                <Link :href="`/categories/${category.slug}/edit`"
                  class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                <PenLine class="w-4 h-4 mr-1" />
                <span class="hidden sm:inline">Edit</span>
                </Link>

                <button @click="deleteCategory(category.slug)"
                  class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
                  <Trash2 class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Delete</span>
                </button>

              </td>
            </tr>

            <tr v-if="props.categories.data.length === 0">
              <td colspan="6" class="text-center py-6 text-gray-500">
                No categories found.
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="props.categories.total > 0" class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4">
          <p class="text-sm text-gray-600">
            Showing {{ props.categories.from }} to {{ props.categories.to }} of {{ props.categories.total }} results
          </p>
          <div class="flex flex-wrap gap-1">
            <button :disabled="props.categories.current_page === 1"
              @click="handlePaginate(props.categories.current_page - 1)"
              class="px-3 py-1 border text-sm rounded-md hover:bg-gray-100 disabled:opacity-50">
              Prev
            </button>

            <button v-for="page in props.categories.last_page" :key="page" @click="handlePaginate(page)" :class="[
              'px-3 py-1 text-sm rounded-md border',
              props.categories.current_page === page
                ? 'bg-blue-600 text-white border-blue-600'
                : 'hover:bg-gray-100 text-gray-700'
            ]">
              {{ page }}
            </button>

            <button :disabled="props.categories.current_page === props.categories.last_page"
              @click="handlePaginate(props.categories.current_page + 1)"
              class="px-3 py-1 border text-sm rounded-md hover:bg-gray-100 disabled:opacity-50">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
