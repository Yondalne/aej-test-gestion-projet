<template>
    <aside
        :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', 'fixed inset-y-0 left-0 z-40 w-64 bg-indigo-800 overflow-y-auto transition duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0']">
        <!-- Sidebar Header / Logo -->
        <div class="flex items-center justify-center h-16 px-6 bg-indigo-900">
            <div class="flex items-center">
                <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="ml-2 text-xl font-bold text-white">ProNova</span>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="mt-5 px-2 space-y-1">
            <SidebarLink href="/dashboard" :is-active="isActive('/dashboard')">
                <template #icon>
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </template>
                Tableau de bord
            </SidebarLink>

            <SidebarLink href="/projets" :is-active="isActive('/projets')">
                <template #icon>
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </template>
                Liste des projets
            </SidebarLink>

            <SidebarLink v-if="user && user.role === 'promoteur'" href="/projets/create"
                :is-active="isActive('/projets/create')">
                <template #icon>
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </template>
                Nouveau projet
            </SidebarLink>

            <div v-if="user && user.role === 'admin'" class="mt-6 pt-6 border-t border-indigo-700">
                <h3 class="px-3 text-xs font-semibold text-indigo-200 uppercase tracking-wider">
                    Administration
                </h3>
                <div class="mt-3 space-y-1">
                    <a href="/projets/export-pdf/all"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-indigo-100 hover:bg-indigo-700">
                        <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM14 3.5V9h5.5M9 13h6m-6 4h6" />
                        </svg>
                        Exporter Tous les Projets
                    </a>

                    <!-- <SidebarLink href="/admin/users" :is-active="isActive('/admin/users')">
                        <template #icon>
                            <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                        Gestion des utilisateurs
                    </SidebarLink> -->
                </div>
            </div>
        </nav>
    </aside>
</template>

<script setup>
import SidebarLink from '@/Components/SidebarLink.vue';

defineProps({
    sidebarOpen: {
        type: Boolean,
        required: true
    },
    user: {
        type: Object,
        required: true
    },
    isActive: {
        type: Function,
        required: true
    }
});
</script>
