<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import ManagerLayout from "./Components/managerLayout.vue";

const form = useForm({});
const logout = () => {
  form.post(route("logout"));
};

const page = usePage();
const site = page.props.site;
const totalUsers = page.props.total_users;
const totalEquipments = page.props.total_equipments;
const recentAssignments = ref(page.props.recent_assignments || []);
</script>

<template>
        <ManagerLayout>

  <div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800">Manager Dashboard</h1>

    <p class="mt-4 text-lg font-semibold">Site: {{ site.name }}</p>

    <!-- Statistics Section -->
    <div class="mt-6 grid grid-cols-3 gap-6">
      <div class="p-4 bg-blue-100 text-blue-700 rounded-lg">
        <h2 class="text-lg font-semibold">Total Users</h2>
        <p class="text-2xl">{{ totalUsers }}</p>
      </div>
      <div class="p-4 bg-green-100 text-green-700 rounded-lg">
        <h2 class="text-lg font-semibold">Total Equipments</h2>
        <p class="text-2xl">{{ totalEquipments }}</p>
      </div>
      <div class="p-4 bg-yellow-100 text-yellow-700 rounded-lg">
        <h2 class="text-lg font-semibold">Pending Approvals</h2>
        <p class="text-2xl">5</p>
      </div>
    </div>

    <!-- Recent Equipment Assignments -->
    <div class="mt-6 p-4 bg-white shadow rounded-lg">
      <h2 class="text-lg font-semibold text-gray-800">Recent Equipment Assignments</h2>
      <ul class="mt-3 space-y-2">
        <li v-for="assignment in recentAssignments" :key="assignment.id" class="flex justify-between p-2 border-b">
          <span>{{ assignment.user_name }} - {{ assignment.equipment_name }}</span>
          <span class="text-gray-500 text-sm">{{ assignment.assigned_at }}</span>
        </li>
      </ul>
    </div>

    <!-- Assign Equipment Button -->
    <div class="mt-6">
      <button
        @click="$inertia.visit(route('manager.assign_equipment'))"
        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
      >
        Assign New Equipment
      </button>
    </div>

    <!-- Logout Button -->
    <button
      @click="logout"
      class="mt-6 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg"
    >
      Logout
    </button>
  </div>
</ManagerLayout>

</template>
