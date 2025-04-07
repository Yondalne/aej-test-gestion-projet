<template>
    <div class="rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl" :class="`bg-${color}-100`">
        <div class="p-6">
            <div class="flex items-center">
                <div class="ml-6">
                    <p class="text-sm font-semibold text-gray-600 truncate">
                        {{ title }}
                    </p>
                    <p class="mt-2 text-4xl font-bold text-gray-900">
                        {{ value }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [Number, String],
        required: true
    },
    color: {
        type: String,
        default: 'blue',
        validator: (value) => ['blue', 'green', 'red', 'yellow', 'indigo', 'purple', 'pink', 'teal', 'orange'].includes(value)
    },
    icon: {
        type: String,
        default: 'document-text'
    }
});

// Convertir le nom de l'icône en composant avec une bibliothèque plus riche d'icônes
const resolvedIcon = computed(() => {
    const icons = {
        // Icônes de base
        'document-text': DocumentTextIcon,
        'check-circle': CheckCircleIcon,
        'x-circle': XCircleIcon,
        'clock': ClockIcon,

        // Icônes additionnelles
        'users': UserGroupIcon,
        'currency': CurrencyDollarIcon,
        'chart': ChartBarIcon,
        'calendar': CalendarIcon,
        'briefcase': BriefcaseIcon,
        'documents': DocumentDuplicateIcon,
        'idea': LightBulbIcon,
        'security': ShieldCheckIcon
    };

    return icons[props.icon] || DocumentTextIcon;
});
</script>
