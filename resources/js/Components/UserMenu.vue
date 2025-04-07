<template>
    <div class="relative">
        <button
            @click="userMenuOpen = !userMenuOpen"
            type="button"
            class="flex items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            ref="userMenuButton"
        >
            <span class="sr-only">Ouvrir le menu utilisateur</span>
            <UserAvatar :user="user" />
            <span class="ml-3 text-gray-700">{{ user && user.prenoms ? `${user.prenoms} ${user.nom}` : 'Utilisateur' }}</span>
            <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div
            v-show="userMenuOpen"
            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        >
            <div class="block px-4 py-2 text-xs text-gray-500">
                Connecté en tant que: <span class="font-medium">{{ user && user.role ? user.role : 'invité' }}</span>
            </div>
            <form method="POST" @submit.prevent="$emit('logout')">
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import UserAvatar from '@/Components/UserAvatar.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

defineEmits(['logout']);

const userMenuOpen = ref(false);
const userMenuButton = ref(null);

// Close user menu when clicking outside
function closeUserMenu(e) {
    if (userMenuOpen.value && userMenuButton.value && !userMenuButton.value.contains(e.target)) {
        userMenuOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', closeUserMenu);
});

onUnmounted(() => {
    document.removeEventListener('click', closeUserMenu);
});
</script>
