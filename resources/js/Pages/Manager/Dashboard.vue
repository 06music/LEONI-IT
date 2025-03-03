<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({});

const logout = () => {
  form.post(route("logout"));
};
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800">Manager Dashboard</h1>

    <p class="mt-4">Site: Example Site</p>
    <p>Total Users: 30</p>
    <p>Total Equipments: 150</p>

    <!-- Logout Button -->
    <button
      @click="logout"
      class="mt-6 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg"
    >
      Logout
    </button>
  </div>
</template>
