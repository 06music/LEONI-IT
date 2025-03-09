<template>
    <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-600 fixed w-full top-0 z-50 shadow-sm">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Left Section -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Logo -->
                    <Link href="/" class="flex items-center gap-2 group">
                        <img src="/images/logo.png" alt="IT.Leoni" class="h-20 w-auto transition-transform group-hover:scale-105">
                        <span class="text-xl font-bold tracking-tight text-gray-800 dark:text-white"></span>
                    </Link>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-4">


                    <!-- User Menu -->
                    <Menu as="div" class="relative">
                        <MenuButton class="flex items-center gap-2 focus:outline-none">
                            <div class="relative">
                                <img class="h-8 w-8 rounded-full ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-gray-300 dark:hover:ring-gray-500 transition-all"
                                     src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                                     alt="User avatar">
                            </div>
                        </MenuButton>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems class="absolute right-0 mt-2 w-48 origin-top-right divide-y divide-gray-100 dark:divide-gray-600 rounded-lg bg-white dark:bg-gray-700 shadow-lg border border-gray-100 dark:border-gray-600 focus:outline-none">
                                <div class="p-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link href="#" :class="[active ? 'bg-gray-50 dark:bg-gray-600' : '', 'block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg']">
                                            Profile
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link href="#" :class="[active ? 'bg-gray-50 dark:bg-gray-600' : '', 'block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg']">
                                            Settings
                                        </Link>
                                    </MenuItem>
                                </div>
                                <div class="p-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link :href="route('logout')" method="post" as="button" :class="[active ? 'bg-gray-50 dark:bg-gray-600' : '', 'block w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg text-left']">
                                            Sign Out
                                        </Link>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
</script>
