<template>
    <span :class="badgeClasses">
        <span :class="dotClasses"></span>
        {{ statusLabel }}
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true
    }
});

const statusConfig = computed(() => {
    const config = {
        'Validé': {
            label: 'Validé',
            bgColor: 'bg-green-100',
            textColor: 'text-green-800',
            dotColor: 'bg-green-400'
        },
        'Rejeté': {
            label: 'Rejeté',
            bgColor: 'bg-red-100',
            textColor: 'text-red-800',
            dotColor: 'bg-red-400'
        },
        'En Attente': {
            label: 'En attente',
            bgColor: 'bg-yellow-100',
            textColor: 'text-yellow-800',
            dotColor: 'bg-yellow-400'
        },
        'default': {
            label: 'Inconnu',
            bgColor: 'bg-gray-100',
            textColor: 'text-gray-800',
            dotColor: 'bg-gray-400'
        }
    };

    return config[props.status] || config.default;
});

const statusLabel = computed(() => {
    return statusConfig.value.label;
});

const badgeClasses = computed(() => {
    return `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusConfig.value.bgColor} ${statusConfig.value.textColor}`;
});

const dotClasses = computed(() => {
    return `-ml-0.5 mr-1.5 h-2 w-2 rounded-full ${statusConfig.value.dotColor}`;
});
</script>
