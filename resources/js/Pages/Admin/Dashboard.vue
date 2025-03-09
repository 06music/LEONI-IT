<template>
    <AdminLayout>
        <div class="p-6">
            <!-- Top Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center">
                    <UserIcon class="w-10 h-10 text-blue-500 dark:text-blue-400 mr-3" />
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Users</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ totalUsers }}</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center">
                    <BuildingOfficeIcon class="w-10 h-10 text-green-500 dark:text-green-400 mr-3" />
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Sites</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ totalSites }}</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center">
                    <ComputerDesktopIcon class="w-10 h-10 text-yellow-500 dark:text-yellow-400 mr-3" />
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Equipments</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ totalEquipments }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Computers Table -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Recent Computers</h2>
                <el-table :data="recentComputers" stripe border style="width: 100%">
                    <el-table-column prop="computer_name" label="Computer Name" sortable />
                    <el-table-column prop="model" label="Model" sortable />
                    <el-table-column prop="mac_address" label="MAC Address" sortable />
                    <el-table-column prop="site_id" label="Site ID" sortable />
                </el-table>
            </div>

            <!-- Chart Section -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Computers by Site</h2>
                <BarChart :chart-data="chartData" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import AdminLayout from './Components/AdminLayout.vue';
import {
    UserIcon,
    BuildingOfficeIcon,
    ComputerDesktopIcon,
} from '@heroicons/vue/24/solid';
import BarChart from '@/Components/Charts/BarChart.vue';

// Receive props from backend
const props = defineProps({
    totalUsers: Number,
    totalSites: Number,
    totalEquipments: Number,
    recentComputers: Array,
});

// Chart Data
const chartData = computed(() => ({
    labels: ['Site 1', 'Site 2'],
    datasets: [
        {
            label: 'Computers',
            data: [30, 50], // Replace with actual site data
            backgroundColor: ['#3B82F6', '#10B981'],
        }
    ]
}));

// Initialize Flowbite
onMounted(() => {
    initFlowbite();
});
</script>
