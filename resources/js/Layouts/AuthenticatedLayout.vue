<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- Sidebar Mobile Overlay -->
        <div v-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-600 bg-opacity-75 transition-opacity lg:hidden"
            @click="sidebarOpen = false"></div>

        <div class="flex min-h-screen">
            <!-- Sidebar Component -->
            <Sidebar :sidebar-open="sidebarOpen" :user="user" :is-active="isActive" />

            <div class="flex flex-1 flex-col">
                <!-- Topbar Component -->
                <Topbar :user="user" @toggle-sidebar="sidebarOpen = !sidebarOpen" @logout="logout" />

                <!-- Main Content -->
                <main class="flex-1">
                    <div class="py-6">
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                            <h1 v-if="title" class="text-2xl font-semibold text-gray-900 mb-6">{{ title }}</h1>
                            <div class="py-4">
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Toast Listener Component -->
        <ToastListener />
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Topbar from '@/Components/Topbar.vue';
import ToastListener from '@/Components/ToastListener.vue';

const props = defineProps({
    title: {
        type: String,
        default: ''
    }
});

// Sidebar state
const sidebarOpen = ref(false);

// User data from Inertia shared props
const page = usePage();
const user = computed(() => page.props.auth?.user || {});

// Check if the current path matches the link
function isActive(path) {
    return page.url.startsWith(path);
}

// Close sidebar when navigating (on mobile)
watch(() => page.url, () => {
    sidebarOpen.value = false;
});

// Logout function
function logout() {
    router.post('/logout');
}
</script>
