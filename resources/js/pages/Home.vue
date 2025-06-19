<script setup>
import ClientLayout from '@/layouts/Clientlayout.vue'
import { Head } from '@inertiajs/vue3'

import Slider from '@/components/client/home/Slider.vue'
import FeaturedProduct from '@/components/client/home/FeaturedProduct.vue'
import Category from '@/components/client/home/Category.vue'
import NewArrivals from '@/components/client/home/NewArrivals.vue'
import FlashDeals from '@/components/client/home/FlashDeals.vue'
import WhyChooseUs from '@/components/client/home/ChooseUs.vue'
import Testimonials from '@/components/client/home/Testimonials.vue'
import NewsletterSignup from '@/components/client/home/NewsletterSignup.vue'
import { defineProps, ref, watch } from 'vue'

 
 

const props = defineProps({
  products: {
    type: Array,
    required: true,
  },
  auth: {
    type: Object,
    required: true,
  },
});


 


 

// const categories = [
//   { name: 'Electronics', image: 'https://cdn-icons-png.flaticon.com/512/1555/1555401.png' },
//   { name: 'Fashion', image: '/img/fashion.jpg' },
//   { name: 'Home & Living', image: '/img/home.jpg' },
//   { name: 'Books', image: '/img/books.jpg' },
//   { name: 'Toys', image: '/img/toys.jpg' },
//   { name: 'Beauty', image: '/img/beauty.jpg' },
//   { name: 'Sports', image: '/img/sports.jpg' },
//   { name: 'Groceries', image: '/img/grocery.jpg' },
// ]

const newArrivals = [
  {
    id: 1,
    name: 'Eco-Friendly Water Bottle',
    price: '$24.99',
    image: '/images/bottle.jpg',
  },
  {
    id: 2,
    name: 'Bluetooth Speaker',
    price: '$39.99',
    image: '/images/speaker.jpg',
  },
]

const flashDeals = [
  {
    id: 1,
    name: 'LED Lamp',
    description: 'Brighten your workspace.',
    price: '$14.99',
    image: '/images/lamp.jpg',
  },
  {
    id: 2,
    name: 'Gaming Mouse',
    description: 'Precision and comfort combined.',
    price: '$29.99',
    image: '/images/mouse.jpg',
  },
]

const features = [
  {
    icon: '🚚',
    title: 'Free Shipping',
    description: 'On all orders above $50.',
  },
  {
    icon: '💳',
    title: 'Secure Payments',
    description: '100% secure & encrypted.',
  },
  {
    icon: '⚡',
    title: 'Fast Delivery',
    description: 'We deliver within 48 hours.',
  },
]

const testimonials = [
  {
    name: 'Alice Smith',
    message: 'Amazing service and quick delivery!',
    role: 'Happy Customer',
  },
  {
    name: 'Bob Johnson',
    message: 'Great quality and affordable prices.',
    role: 'Verified Buyer',
  },
]


const sliders = ref([
  {
    id: 1,
    image: 'https://img.freepik.com/free-psd/black-friday-super-sale-facebook-cover-banner-template_120329-5177.jpg?semt=ais_hybrid&w=740',
    title: 'Summer Collection',
    description: 'Discover our vibrant new summer arrivals',
  },
  {
    id: 2,
    image: 'https://images.remotehub.com/d42c62669a7711eb91397e038280fee0/original_thumb/ec1eb042.jpg?version=1618112516',
    title: 'Limited Deals',
    description: 'Grab exclusive offers before they’re gone!',
  },
  {
    id: 3,
    image: 'https://graphicsfamily.com/wp-content/uploads/edd/2021/07/Shop-Products-Social-Media-Banner-Design-Template-scaled.jpg',
    title: 'Eco-Friendly Picks',
    description: 'Shop sustainable products curated just for you',
  },
]);
</script>

<template>
  <Head title="Home" />

  <ClientLayout>
   
    <section class="max-w-[1550px] mx-auto bg-white  pb-5">
      <!-- Hero / Slider -->
      <Slider :sliders="sliders" />

      <!-- Featured Products -->
      <FeaturedProduct :products="products" :auth="auth" />

      <!-- Product Categories -->
      <Category :categories="categories" />

      <!-- New Arrivals -->
      <NewArrivals :arrivals="newArrivals" />

      <!-- Flash Deals -->
      <FlashDeals :deals="flashDeals" />

      <!-- Why Choose Us -->
      <WhyChooseUs :features="features" />

      <!-- Testimonials -->
      <Testimonials :testimonials="testimonials" />

      <!-- Newsletter Signup -->
      <NewsletterSignup />
    </section>
  </ClientLayout>
</template>
