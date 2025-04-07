<template>
    <div></div>
</template>

<script setup>
import { useToast } from 'vue-toastification';
import { usePage } from '@inertiajs/vue3';
import { watch, onMounted } from 'vue';

const toast = useToast();
const page = usePage();

// Fonction pour afficher les toasts basés sur les données flash de Laravel
function handleFlashMessages() {
    const { flash } = page.props;

    if (flash.success) {
        toast.success(flash.success, {
            timeout: 5000,
            icon: true
        });
    }

    if (flash.error) {
        toast.error(flash.error, {
            timeout: 8000, // Plus long pour les erreurs
            icon: true
        });
    }

    if (flash.message) {
        toast.info(flash.message, {
            timeout: 5000,
            icon: true
        });
    }

    // Vérifier les erreurs de validation Laravel
    const errors = page.props.errors;
    if (errors && Object.keys(errors).length > 0) {
        const firstErrorKey = Object.keys(errors)[0];
        const firstError = errors[firstErrorKey][0];
        if (firstError) {
            toast.error(`${firstErrorKey}: ${firstError}`, {
                timeout: 8000
            });
        }
    }
}

// Lors du montage du composant, vérifier s'il y a des messages flash
onMounted(() => {
    handleFlashMessages();
});

// Observer les changements dans les props pour attraper les nouveaux messages flash
// après les navigations ou les requêtes Inertia
watch(() => page.props.flash, () => {
    handleFlashMessages();
}, { deep: true });
</script>
