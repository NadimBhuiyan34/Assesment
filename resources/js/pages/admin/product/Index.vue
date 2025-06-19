<script setup lang="ts">
import { defineProps, ref, watch } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Trash2, PenLine, Images } from 'lucide-vue-next';

interface Product {
    id: string;
    name: string;
    stock: string;
    slug: string;
    status: boolean;
}

const props = defineProps<{
    products: {
        data: Product[];
        current_page: number;
        last_page: number;
        total: number;
        from: number;
        to: number;
    };
    filters: { search?: string };
}>();

const search = ref(props.filters?.search || '');
const isLoading = ref(false);

watch(search, async (value) => {
    isLoading.value = true;
    await router.get('/products', { search: value }, {
        preserveState: true,
        replace: true,
        onFinish: () => isLoading.value = false
    });
}, { immediate: true });


const deleteProduct = (slug: string) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(`/products/${slug}`, {
            preserveScroll: true,
            onSuccess: () => {
                alert('✅ Product deleted successfully!')
            },
            onError: () => {
                alert('❌ Failed to delete category.')
            }
        })
    }
}


const handlePaginate = (page: number) => {
    router.get('/products', { search: search.value, page }, {
        preserveState: true,
        replace: true,
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Product', href: '/products' },
];
</script>

<template>

    <Head title="Product" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 w-full mx-auto space-y-6 bg-gray-100">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Product</h1>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <input v-model="search" type="text" placeholder="Search by name..."
                        class="w-full sm:w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" />
                    <Link href="/products/create"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                    + Add New Product
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg shadow bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-blue-100">
                        <tr>

                            <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
                            <th class="px-4 py-3 font-semibold text-gray-600">Stock</th>
                            <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="product in props.products.data" :key="product.id"
                            class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3">{{ product.name }}</td>
                            <td class="px-4 py-3">{{ product.stock }}</td>
                            <td class="px-4 py-3">
                                <span :class="product.status ? 'text-green-600' : 'text-red-500'" class="font-medium">
                                    {{ product.status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right flex justify-end gap-2">
                                <Link :href="route('product_images.index', { slug: product.slug })"
                                    class="inline-flex items-center px-2 py-1 bg-green-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                                <Images class="w-4 h-4 mr-1" />
                                <span class="hidden sm:inline">Image Upload</span>
                                </Link>

                                <Link :href="`/products/${product.slug}/edit`"
                                    class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                                <PenLine class="w-4 h-4 mr-1" />
                                <span class="hidden sm:inline">Edit</span>
                                </Link>
                                <button @click="deleteProduct(product.slug)"
                                    class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
                                    <Trash2 class="w-4 h-4 mr-1" />
                                    <span class="hidden sm:inline">Delete</span>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="props.products.data.length === 0">
                            <td colspan="5" class="text-center py-6 text-gray-500">No sliders found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="props.products.total > 0"
                class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4">
                <p class="text-sm text-gray-600">
                    Showing {{ props.products.from }} to {{ props.products.to }} of {{ props.products.total }} results
                </p>

                <div class="flex flex-wrap gap-1">
                    <button :disabled="props.products.current_page === 1"
                        @click="handlePaginate(props.products.current_page - 1)"
                        class="px-3 py-1 border text-sm rounded-md hover:bg-gray-100 disabled:opacity-50">
                        Prev
                    </button>

                    <button v-for="page in props.products.last_page" :key="page" @click="handlePaginate(page)" :class="[
                        'px-3 py-1 text-sm rounded-md border',
                        props.products.current_page === page
                            ? 'bg-blue-600 text-white border-blue-600'
                            : 'hover:bg-gray-100 text-gray-700'
                    ]">
                        {{ page }}
                    </button>

                    <button :disabled="props.products.current_page === props.products.last_page"
                        @click="handlePaginate(props.products.current_page + 1)"
                        class="px-3 py-1 border text-sm rounded-md hover:bg-gray-100 disabled:opacity-50">
                        Next
                    </button>
                </div>
            </div>


            <!-- Loading Spinner -->
            <div v-if="isLoading" class="flex justify-center items-center py-4">
                <span class="text-gray-500">Loading...</span>
            </div>
        </div>
    </AppLayout>
</template>
