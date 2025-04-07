<template>
    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white uppercase">
        <img v-if="user.photo_path" :src="'/storage/'+user.photo_path" alt="User Avatar" class="h-full w-full rounded-full object-cover" />
        <span v-else>{{ initials }}</span>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const initials = computed(() => {
    const firstInitial = props.user?.prenoms ? props.user.prenoms.charAt(0) : 'U';
    const lastInitial = props.user?.nom ? props.user.nom.charAt(0) : '';
    return firstInitial + lastInitial;
});
</script>
