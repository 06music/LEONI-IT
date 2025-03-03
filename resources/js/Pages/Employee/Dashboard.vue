<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({});

const logout = () => {
  form.post(route("logout"));
};
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800">Employee Dashboard</h1>

    <h2 class="mt-4">Your Equipments</h2>
    <ul class="mt-2">
      <li>Laptop (Dell XPS 13)</li>
      <li>Monitor (LG UltraWide)</li>
    </ul>

    <!-- Logout Button -->
    <button
      @click="logout"
      class="mt-6 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg"
    >
      Logout
    </button>
  </div>
</template>
