<template>
    <div
        class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12 flex flex-col justify-center sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Connexion à votre compte</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ou
                    <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                        créez un nouveau compte
                    </a>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <form @submit.prevent="submitForm" class="space-y-6" action="#" method="POST">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Adresse email
                            </label>
                            <div class="mt-1">
                                <input
                                    v-model="form.email"
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    @blur="validateEmail"
                                    :class="[
                                        'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                                        errors.email || formErrors.email ? 'border-red-300' : 'border-gray-300'
                                    ]"
                                />
                            </div>
                            <p v-if="formErrors.email" class="mt-2 text-sm text-red-600">{{ formErrors.email }}</p>
                            <p v-else-if="errors && errors.email" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <div class="mt-1">
                                <input
                                    v-model="form.password"
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    @blur="validatePassword"
                                    :class="[
                                        'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                                        errors.password || formErrors.password ? 'border-red-300' : 'border-gray-300'
                                    ]"
                                />
                            </div>
                            <p v-if="formErrors.password" class="mt-2 text-sm text-red-600">{{ formErrors.password }}</p>
                            <p v-else-if="errors && errors.password" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input v-model="form.remember" id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                    Se souvenir de moi
                                </label>
                            </div>

                            <div class="text-sm">
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Mot de passe oublié?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                :disabled="isSubmitting || !isFormValid"
                                :class="[
                                    'w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white',
                                    isSubmitting || !isFormValid
                                        ? 'bg-indigo-300 cursor-not-allowed'
                                        : 'bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 hover:from-indigo-700 hover:via-purple-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
                                ]"
                            >
                                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ isSubmitting ? 'Connexion en cours...' : 'Se connecter' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const formErrors = reactive({
    email: '',
    password: '',
});

const isSubmitting = ref(false);

// Email validation
const validateEmail = () => {
    formErrors.email = '';

    if (!form.email) {
        formErrors.email = 'L\'adresse email est requise';
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(form.email)) {
        formErrors.email = 'Veuillez saisir une adresse email valide';
        return false;
    }

    return true;
};

// Password validation
const validatePassword = () => {
    formErrors.password = '';

    if (!form.password) {
        formErrors.password = 'Le mot de passe est requis';
        return false;
    }

    if (form.password.length < 6) {
        formErrors.password = 'Le mot de passe doit contenir au moins 6 caractères';
        return false;
    }

    return true;
};

// Form validation
const validateForm = () => {
    const isEmailValid = validateEmail();
    const isPasswordValid = validatePassword();

    return isEmailValid && isPasswordValid;
};

const isFormValid = computed(() => {
    return form.email && form.password && !formErrors.email && !formErrors.password;
});

const submitForm = () => {
    if (!validateForm()) {
        return;
    }

    isSubmitting.value = true;

    form.post('/login', {
        onFinish: () => {
            isSubmitting.value = false;
        }
    });
};

defineProps({
    errors: Object,
});
</script>
