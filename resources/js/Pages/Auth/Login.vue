<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const users = [
    { name: 'Super Admin', email: 'admin@example.com', role: 'super_admin', password: 'password' },
    { name: 'Site Manager', email: 'manager@example.com', role: 'manager', password: 'password' },
    { name: 'Superior Hierarchique', email: 'superior@example.com', role: 'superior_hierarchique', password: 'password' },
    { name: 'John Doe', email: 'employee@example.com', role: 'employee', password: 'password' },
];

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>

        <div class="mt-6 bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-bold mb-4">Existing Users</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Role</th>
                        <th class="border border-gray-300 px-4 py-2">Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.email" class="text-center">
                        <td class="border border-gray-300 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ user.email }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ user.role }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ user.password }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </GuestLayout>
</template>
