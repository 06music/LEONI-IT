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
              :href="route('dashboard.manager')"
              class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group"
            >
              <span class="ml-3 font-medium">Dashboard</span>
            </Link>
          </li>

          <!-- Users Management -->
          <li>
            <Link :href="route('manager.users')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <span class="ml-3 font-medium">Users</span>
            </Link>
          </li>

          <!-- Equipment Management -->
          <li>
            <Link :href="route('manager.equipments')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <span class="ml-3 font-medium">Equipments</span>
            </Link>
          </li>

          <!-- Computers Management -->
          <li>
            <Link :href="route('manager.computers')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <span class="ml-3 font-medium">Computers</span>
            </Link>
          </li>

          <!-- Assign Equipment -->
          <li>
            <Link :href="route('manager.assign_equipment')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <span class="ml-3 font-medium">Assign Equipment</span>
            </Link>
          </li>

          <!-- Return Equipment -->
          <li>
            <Link :href="route('manager.return_equipment')" class="flex items-center p-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
              <span class="ml-3 font-medium">Return Equipment</span>
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
