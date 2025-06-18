<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Undo2 } from 'lucide-vue-next';
import { defineProps } from 'vue';

// --- Types --------------------------------------------------------------
interface Category { id: string; name: string, slug: string }
interface Brand { id: string; name: string, slug: string }
interface Shop { id: string; name: string, slug: string }

// --- Props --------------------------------------------------------------
const props = defineProps<{
    categories: Category[];
    brands: Brand[];
    shops: Shop[];
}>();

// --- Form state ---------------------------------------------------------
const form = useForm({
    name: '',
    slug: '',
    description: '',
    price: '',
    discount_price: '',
    stock: 0,
    is_featured: false,
    is_active: true,
    weight: '',
    length: '',
    width: '',
    height: '',
    category_id: '',
    brand_id: '',
    shop_id: '',
    tags: '',   // comma-separated -> "new,summer,sale"
    specifications: '',   // JSON string      -> {"color":"red"}
    status: true,
});

const submit = () => form.post('/products');

// --- UI helpers ---------------------------------------------------------
const breadcrumbs = [
    { title: 'Products', href: '/products' },
    { title: 'Create', href: '/products/create' },
];
</script>

<template>

    <Head title="Product – Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">Create New Product</h1>

            <form @submit.prevent="submit" class="space-y-5 bg-white p-6 rounded-xl shadow-md w-full mx-auto">

                <!-- Basic info -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input v-model="form.name" type="text"
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
                </div>



                <div>
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea v-model="form.description" rows="4"
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}
                    </p>
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Price</label>
                        <input v-model="form.price" type="number" step="0.01"
                            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors.price" class="text-red-600 text-sm mt-1">{{ form.errors.price }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Discount Price</label>
                        <input v-model="form.discount_price" type="number" step="0.01"
                            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors.discount_price" class="text-red-600 text-sm mt-1">{{
                            form.errors.discount_price }}</p>
                    </div>
                </div>

                <!-- Inventory -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Stock</label>
                    <input v-model="form.stock" type="number" min="0"
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <p v-if="form.errors.stock" class="text-red-600 text-sm mt-1">{{ form.errors.stock }}</p>
                </div>

                <!-- Flags -->
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center space-x-2">
                        <input v-model="form.is_featured" type="checkbox" />
                        <span>Featured</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input v-model="form.is_active" type="checkbox" />
                        <span>Active</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input v-model="form.status" type="checkbox" />
                        <span>Status (True = visible)</span>
                    </label>
                </div>

                <!-- Dimensions -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div v-for="dim in ['weight', 'length', 'width', 'height']" :key="dim">
                        <label class="block text-gray-700 font-medium mb-1 capitalize">{{ dim }}</label>
                        <input v-model="form[dim]" type="number" step="0.01" min="0"
                            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors[dim]" class="text-red-600 text-sm mt-1">{{ form.errors[dim] }}</p>
                    </div>
                </div>

                <!-- Relations -->
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Category</label>
                        <select v-model="form.category_id"
                            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">-- Select --</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="text-red-600 text-sm mt-1">{{ form.errors.category_id
                        }}</p>
                    </div>

                </div>

                <!-- Tags & Specifications -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tags (comma-separated)</label>
                    <input v-model="form.tags" type="text" placeholder="new,summer,sale"
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <p v-if="form.errors.tags" class="text-red-600 text-sm mt-1">{{ form.errors.tags }}</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Specifications (JSON)</label>
                    <textarea v-model="form.specifications" rows="3" placeholder='{"color":"red"}'
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    <p v-if="form.errors.specifications" class="text-red-600 text-sm mt-1">{{ form.errors.specifications
                    }}</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-1 rounded hover:bg-blue-700 disabled:opacity-60"
                        :disabled="form.processing">
                        Save
                    </button>

                    <Link href="/products"
                        class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
                    <Undo2 class="w-4 h-4 mr-1" /> Back
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
