<template>
  <footer class="bg-gray-100 text-gray-700 pt-10 pb-6 px-4 md:px-10  mx-auto w-full">
    <div class=" mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
      
      <!-- Brand Info -->
      <div>
        <h2 class="text-2xl font-bold text-gray-900">ShopMate</h2>
        <p class="text-sm mt-2">
          Your one-stop shop for electronics, fashion, and more.
        </p>
        <div class="flex space-x-4 mt-4">
          <a href="#" class="text-gray-600 hover:text-blue-600">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="text-gray-600 hover:text-blue-400">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-gray-600 hover:text-pink-500">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>

      <!-- Shop Links -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Shop</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-blue-600">Men</a></li>
          <li><a href="#" class="hover:text-blue-600">Women</a></li>
          <li><a href="#" class="hover:text-blue-600">Electronics</a></li>
          <li><a href="#" class="hover:text-blue-600">Home & Garden</a></li>
        </ul>
      </div>

      <!-- Help Links -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Help</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-blue-600">Customer Service</a></li>
          <li><a href="#" class="hover:text-blue-600">Shipping</a></li>
          <li><a href="#" class="hover:text-blue-600">Returns</a></li>
          <li><a href="#" class="hover:text-blue-600">FAQ</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Newsletter</h3>
        <p class="text-sm mb-2">
          Subscribe to get exclusive deals and latest updates.
        </p>
        <form class="flex">
          <input
            type="email"
            placeholder="Your email"
            class="w-full px-3 py-2 rounded-l bg-white border border-gray-300 text-sm focus:outline-none"
          />
          <button class="px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-r">
            Subscribe
          </button>
        </form>
      </div>
    </div>

    <!-- Payment Icons + Copyright -->
    <div class="max-w-7xl mx-auto mt-10 border-t pt-6 text-center text-sm text-gray-500">
      <div class="flex justify-center space-x-4 mb-4">
        <img src="https://img.icons8.com/color/40/000000/visa.png" alt="Visa" />
        <img src="https://img.icons8.com/color/40/000000/mastercard.png" alt="Mastercard" />
        <img src="https://img.icons8.com/color/40/000000/paypal.png" alt="Paypal" />
      </div>
      <p>&copy; 2025 ShopMate. All rights reserved.</p>
    </div>
  </footer>
</template>

<script setup>
// FontAwesome icons and payment icons used via CDN or external image links.
</script>
