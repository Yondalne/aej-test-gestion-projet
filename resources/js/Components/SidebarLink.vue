<template>
    <Link
        :href="href"
        class="group flex items-center px-2 py-2 text-base font-medium rounded-md"
        :class="isActive ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700'"
    >
        <slot name="icon"></slot>
        <slot></slot>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true
    },
    isActive: {
        type: Boolean,
        default: false
    }
});
</script>
