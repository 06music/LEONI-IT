<template>
  <div class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
          <!-- Toggle Sidebar Button -->
          <button @click="toggleSidebar"
            class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg v-if="!sidebarOpen" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 5h14M3 10h10M3 15h14" clip-rule="evenodd"></path>
            </svg>
            <svg v-else class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>

          <!-- Logo -->
          <a href="/" class="flex items-center">
            <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="h-8 mr-3" alt="Logo" />
            <span class="text-2xl font-semibold dark:text-white">Admin Panel</span>
          </a>

          <!-- Search Bar -->
          <form action="#" method="GET" class="hidden md:block md:pl-2">
            <label for="topbar-search" class="sr-only">Search</label>
            <div class="relative md:w-64">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                </svg>
              </div>
              <input type="text" id="topbar-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Search" />
            </div>
          </form>
        </div>

        <!-- User Profile & Notifications -->
        <div class="flex items-center space-x-4">
          <button class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">🔔</button>
          <button class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">⚙️</button>
          <button class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">👤</button>
        </div>
      </div>
    </nav>

    <!-- Sidebar -->
    <aside :class="['fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700', sidebarOpen ? 'translate-x-0' : '-translate-x-full']">
      <div class="py-5 px-3">
        <ul class="space-y-2">
          <li>
            <router-link to="/dashboard" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              📊 Dashboard
            </router-link>
          </li>
          <li>
            <router-link to="/users" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              👤 Utilisateurs
            </router-link>
          </li>
          <li>
            <router-link to="/settings" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              ⚙️ Paramètres
            </router-link>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="p-4 md:ml-64 pt-20">
      <slot></slot>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 p-4 text-center dark:bg-gray-800 dark:border-gray-700 fixed bottom-0 w-full">
      <span class="text-gray-600 dark:text-gray-300">© 2025 Admin Panel. Tous droits réservés.</span>
    </footer>
  </div>
</template>

<script setup>
import { ref } from "vue";

const sidebarOpen = ref(false);
const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};
</script>
