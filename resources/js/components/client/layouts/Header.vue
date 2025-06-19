<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref } from 'vue';
import { route } from 'ziggy-js';
// Heroicons (https://github.com/tailwindlabs/heroicons)
import {
    Bars3Icon,
    ChevronDownIcon,
    ChevronUpIcon,
    HeartIcon,
    MagnifyingGlassIcon,
    PowerIcon,
    ShoppingCartIcon,
    UserCircleIcon,
    XMarkIcon,
    Cog6ToothIcon, // ✅ This is the settings icon
} from '@heroicons/vue/24/outline';


const page = usePage();
const user = computed(() => page.props.auth?.user);
const categories = computed(() => page.props.categories ?? []);

const mobileMenuOpen = ref(false);
const categoryOpen = ref(false);
const profileMenuOpen = ref(false);

// Close mobile panel after navigation
const closeMobile = () => {
    mobileMenuOpen.value = false;
};

// Dropdown state
// Reactive dropdown object
const dropdowns = reactive({ main: false });

// Initialize dropdown keys for all categories
onMounted(() => {
    categories.value.forEach((cat) => {
        dropdowns[cat.id] = false;
    });
});

// Toggle dropdown (main or sub)
function toggleDropdown(key) {
    if (key === 'main') {
        // Toggle main dropdown, close all submenus
        dropdowns.main = !dropdowns.main;
        for (const k in dropdowns) {
            if (k !== 'main') dropdowns[k] = false;
        }
    } else {
        // Toggle the clicked submenu, close other submenus
        for (const k in dropdowns) {
            if (k !== 'main' && k !== key) dropdowns[k] = false;
        }
        dropdowns[key] = !dropdowns[key]; // toggle instead of always true
    }
}

// Optional: close all dropdowns (e.g., on outside click)
function closeAll() {
    for (const key in dropdowns) {
        dropdowns[key] = false;
    }
}
</script>

<template>
    <header class="sticky top-0 z-40 mx-auto w-full  bg-white backdrop-blur">
        <!-- Top bar -->
        <div class="container mx-auto flex  items-center justify-between px-4 py-3 lg:py-4">
            <!-- Logo -->
            <Link href="/" class="text-3xl font-extrabold tracking-tight" @click="closeMobile">
                <span class="bg-gradient-to-r from-blue-700 to-purple-500 bg-clip-text text-transparent">Creative Tech </span>
                <span class="text-red-500">Park</span>
            </Link>

            <!-- Desktop search -->
            <div class="mx-8 hidden w-full max-w-lg bg-white lg:flex">
                <div class="flex w-full overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-blue-500">
                    <input type="text" placeholder="Search for products, brands and more" class="flex-1 px-4 py-2 outline-none" />
                    <button class="flex items-center px-4">
                        <MagnifyingGlassIcon class="h-6 w-6" />
                    </button>
                </div>
            </div>

            <!-- Desktop actions -->
            <div class="hidden items-center gap-6 lg:flex">
                <!-- Profile / auth -->
                <div class="relative">
                    <button
                        v-if="user"
                        @click="profileMenuOpen = !profileMenuOpen"
                        class="flex items-center gap-1 font-medium text-gray-700 hover:text-blue-600"
                    >
                        <span class="max-w-[7rem] truncate">{{ user.name }}</span>
                        <ChevronDownIcon v-if="!profileMenuOpen" class="h-4 w-4" />
                        <ChevronUpIcon v-else class="h-4 w-4" />
                    </button>

                    <template v-else>
                        <Link :href="route('login')" class="flex items-center gap-1 text-gray-700 hover:text-blue-600">
                            <UserCircleIcon class="h-5 w-5" />
                            Login
                        </Link>
                    </template>

           
                    <transition name="fade">
                        <div v-if="profileMenuOpen && user" class="absolute right-0 mt-2 w-48 overflow-hidden rounded-lg border bg-white shadow-lg">
                            
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm hover:bg-gray-50"
                            >
                                <PowerIcon class="h-5 w-5" />
                                Logout
                            </Link>
                        </div>
                    </transition>
                </div>

                <!-- Wishlist -->
                <Link href="" class="relative hover:text-blue-600">
                    <HeartIcon class="h-6 w-6" />
                    <span
                        class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white"
                        >10</span
                    >
                </Link>

                <!-- Cart -->
                <Link href="" class="relative hover:text-blue-600">
                    <ShoppingCartIcon class="h-6 w-6" />
                    <span
                        class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white"
                        >20</span
                    >
                </Link>
            </div>

            <!-- Mobile hamburger -->
            <button class="lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu">
                <Bars3Icon v-if="!mobileMenuOpen" class="h-8 w-8 text-gray-700" />
                <XMarkIcon v-else class="h-8 w-8 text-gray-700" />
            </button>
        </div>

        <!-- Desktop navigation -->
        <nav class="mx-auto hidden   border-t bg-blue-700 text-white lg:block">
            <div class="container mx-auto flex max-w-[1550px] items-center gap-6 px-4 py-2 text-sm font-medium text-white">
                <Link href="/" class="rounded-lg p-2 hover:bg-blue-500">Home</Link>
                <Link href="#" class="rounded-lg p-2 hover:bg-blue-500">Shop</Link>
                <Link href="#" class="rounded-lg p-2 hover:bg-blue-500">Deals</Link>
                <Link href="#" class="rounded-lg p-2 hover:bg-blue-500">About</Link>

                <!-- Categories dropdown -->

                <div class="relative inline-block text-left">
                    <!-- Main Dropdown Button -->
                    <button
                        @click="toggleDropdown('main')"
                        type="button"
                        class="inline-flex items-center justify-between gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700"
                        aria-haspopup="true"
                        :aria-expanded="dropdowns.main ? 'true' : 'false'"
                        id="multiLevelDropdownButton"
                    >
                        Category
                        <svg
                            :class="{ 'rotate-180': dropdowns.main }"
                            class="h-4 w-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 10 6"
                        >
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        v-show="dropdowns.main"
                        @click.outside="closeAll"
                        class="absolute z-20 mt-2 w-60 rounded-lg bg-white shadow-xl ring-1 ring-black/5 dark:bg-gray-800"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="multiLevelDropdownButton"
                    >
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li v-for="cat in categories" :key="cat.id" class="group relative">
                                <button
                                    @click.stop="toggleDropdown(cat.id)"
                                    type="button"
                                    class="flex w-full items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                    :aria-expanded="dropdowns[cat.id] ? 'true' : 'false'"
                                >
                                    {{ cat.name }}
                                    <svg
                                        :class="{ 'rotate-90': dropdowns[cat.id] }"
                                        class="h-3 w-3 transition-transform duration-200"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 6 10"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m1 9 4-4-4-4"
                                        />
                                    </svg>
                                </button>

                                <!-- Submenu -->
                                <div
                                    v-show="dropdowns[cat.id]"
                                    class="absolute top-0 left-full z-30 ml-1 w-48 rounded-lg bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-800"
                                    role="menu"
                                >
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <Link
                                                href=""
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                role="menuitem"
                                            >
                                                {{ cat.name }}
                                            </Link>
                                        </li>
                                        <li v-for="(sub, index) in cat.child" :key="index">
                                            <Link
                                                :href="sub.link || '#'"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                role="menuitem"
                                            >
                                                {{ sub.name }}
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile panel -->
        <transition name="slide-down">
            <div v-if="mobileMenuOpen" class="lg:hidden">
                <div class="space-y-4 border-t bg-white p-4">
                    <div class="flex flex-col gap-2 text-base">
                        <Link href="/" class="hover:text-blue-600" @click="closeMobile">Home</Link>
                        <Link href="#" class="hover:text-blue-600">Shop</Link>
                        <Link href="#" class="hover:text-blue-600">Deals</Link>
                        <Link href="#" class="hover:text-blue-600">About</Link>

                        <!-- Mobile categories -->
                        <div class="relative inline-block text-left">
                            <!-- Main Dropdown Button -->
                            <button
                                @click="toggleDropdown('main')"
                                type="button"
                                class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                aria-haspopup="true"
                                :aria-expanded="dropdowns.main ? 'true' : 'false'"
                                id="multiLevelDropdownButton"
                            >
                                Category
                                <svg class="ms-3 h-2.5 w-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                v-show="dropdowns.main"
                                @click.outside="closeAll"
                                class="absolute z-10 mt-2 w-56 divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:bg-gray-700"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="multiLevelDropdownButton"
                            >
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                    <li v-for="cat in categories" :key="cat.id" class="relative">
                                        <button
                                            @click.stop="toggleDropdown(cat.id)"
                                            type="button"
                                            class="flex w-full items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            :aria-expanded="dropdowns[cat.id] ? 'true' : 'false'"
                                        >
                                            {{ cat.name }}
                                            <svg
                                                class="ms-3 h-2.5 w-2.5 rtl:rotate-180"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 6 10"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m1 9 4-4-4-4"
                                                />
                                            </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div
                                            v-show="dropdowns[cat.id]"
                                            class="absolute top-0 left-full z-10 mt-0 ml-0 w-44 divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:bg-gray-700"
                                            role="menu"
                                        >
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                <li>
                                                    <a
                                                        href=""
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                        role="menuitem"
                                                    >
                                                        {{ cat.name }}
                                                    </a>
                                                </li>
                                                <li v-for="(sub, index) in cat.child" :key="index">
                                                    <a
                                                        :href="sub.link || '#'"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                        role="menuitem"
                                                    >
                                                        {{ sub.name }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Auth & icons -->
                    <div class="flex items-center justify-between border-t pt-4">
                        <div>
                            <template v-if="user">
                                <p class="mb-1 font-medium text-gray-700"><UserCircleIcon class="mr-1 inline-block h-5 w-5" /> {{ user.name }}</p>
                                <Link href="/profile" class="block text-sm hover:text-blue-600" @click="closeMobile"> Profile</Link>
                                <Link href="/logout" method="post" as="button" class="block text-left text-sm hover:text-blue-600"> Logout </Link>
                            </template>
                            <template v-else>
                                <Link :href="route('login')" class="text-gray-700 hover:text-blue-600" @click="closeMobile">Login</Link>
                            </template>
                        </div>

                        <div class="flex gap-4">
                            <Link href="#" class="relative hover:text-blue-600">
                                <HeartIcon class="h-6 w-6" />
                                <span
                                    class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white"
                                    >3</span
                                >
                            </Link>
                            <Link href="" class="relative hover:text-blue-600">
                                <ShoppingCartIcon class="h-6 w-6" />
                                <span
                                    class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white"
                                    >20</span
                                >
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-down-enter-active,
.slide-down-leave-active {
    transition:
        transform 0.25s ease,
        opacity 0.25s ease;
}

.slide-down-enter-from,
.slide-down-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
