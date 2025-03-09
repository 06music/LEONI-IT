<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(true);
const isUsersOpen = ref(false);
const isEquipmentOpen = ref(false);
const isComputersOpen = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const page = usePage();
</script>

<template>
  <div>
    <!-- Sidebar -->
    <aside
      :class="[
        'fixed top-0 left-0 z-40 w-64 h-screen pt-16 bg-white dark:bg-gray-850 shadow-xl border-r border-gray-100 dark:border-gray-800 transition-transform duration-300 ease-in-out',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
      ]"
      aria-label="Sidebar"
    >
      <div class="overflow-y-auto py-4 px-3 h-full">
        <ul class="space-y-1">
          <!-- Dashboard -->
          <li>
            <Link
              :href="route('dashboard.super_admin')"
              class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group"
              :class="{ 'bg-gray-50 dark:bg-gray-700': page.url.startsWith('/dashboard') }"
            >
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              <span class="ml-3 font-medium">Dashboard</span>
            </Link>
          </li>

          <!-- Users Management -->
          <li>
            <button
              @click="isUsersOpen = !isUsersOpen"
              class="flex items-center justify-between p-3 w-full text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group"
              aria-controls="users-dropdown"
              :aria-expanded="isUsersOpen"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="ml-3 font-medium">Users</span>
              </div>
              <svg :class="isUsersOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <ul v-show="isUsersOpen" id="users-dropdown" class="pl-9 mt-1 space-y-1">
              <li>
                <Link :href="route('users.index')" class="flex items-center p-2 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <span class="w-1 h-1 mr-3 bg-gray-400 rounded-full"></span>
                  All Users
                </Link>
              </li>
            </ul>
          </li>

          <!-- Equipment Management -->
          <li>
            <button
              @click="isEquipmentOpen = !isEquipmentOpen"
              class="flex items-center justify-between p-3 w-full text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group"
              aria-controls="equipment-dropdown"
              :aria-expanded="isEquipmentOpen"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="ml-3 font-medium">Equipment</span>
              </div>
              <svg :class="isEquipmentOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <ul v-show="isEquipmentOpen" id="equipment-dropdown" class="pl-9 mt-1 space-y-1">
              <li>
                <Link :href="route('equipment-types.index')" class="flex items-center p-2 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <span class="w-1 h-1 mr-3 bg-gray-400 rounded-full"></span>
                  Equipment Types
                </Link>
              </li>
              <li>
                <Link :href="route('equipment-models.index')" class="flex items-center p-2 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <span class="w-1 h-1 mr-3 bg-gray-400 rounded-full"></span>
                  Equipment Models
                </Link>
              </li>
              <li>
                <Link :href="route('equipment-reasons.index')" class="flex items-center p-2 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <span class="w-1 h-1 mr-3 bg-gray-400 rounded-full"></span>
                  Equipment Reasons
                </Link>
              </li>
            </ul>
          </li>

          <!-- Computers Management -->
          <li>
            <button
              @click="isComputersOpen = !isComputersOpen"
              class="flex items-center justify-between p-3 w-full text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group"
              aria-controls="computers-dropdown"
              :aria-expanded="isComputersOpen"
            >
              <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="ml-3 font-medium">Computers</span>
              </div>
              <svg :class="isComputersOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <ul v-show="isComputersOpen" id="computers-dropdown" class="pl-9 mt-1 space-y-1">
              <li>
                <Link :href="route('computers.index')" class="flex items-center p-2 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <span class="w-1 h-1 mr-3 bg-gray-400 rounded-full"></span>
                  All Computers
                </Link>
              </li>
            </ul>
          </li>

          <!-- Site Management -->
          <li>
            <Link :href="route('sites.index')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              <span class="ml-3 font-medium">Sites</span>
            </Link>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Mobile Toggle Button -->
    <button
      @click="toggleSidebar"
      class="fixed top-4 left-4 z-50 md:hidden p-2 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow"
      aria-label="Toggle sidebar"
    >
      <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>
</template>
