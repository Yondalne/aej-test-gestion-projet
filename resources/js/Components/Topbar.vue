<template>
    <header class="sticky top-0 z-10 flex h-16 bg-white shadow">
        <button
            type="button"
            class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden"
            @click="$emit('toggleSidebar')"
        >
            <span class="sr-only">Ouvrir la sidebar</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>

        <div class="flex flex-1 justify-between px-4">
            <div class="flex flex-1"></div>
            <div class="ml-4 flex items-center">
                <UserMenu :user="user" @logout="$emit('logout')" />
            </div>
        </div>
    </header>
</template>

<script setup>
import UserMenu from '@/Components/UserMenu.vue';

defineProps({
    user: {
        type: Object,
        required: true
    }
});

defineEmits(['toggleSidebar', 'logout']);
</script>
