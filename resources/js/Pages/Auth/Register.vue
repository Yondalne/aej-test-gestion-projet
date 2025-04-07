<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Créer un compte</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ou
                    <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                        connectez-vous à votre compte existant
                    </a>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <!-- Affichage des erreurs globales -->
                    <div v-if="formHasErrors || (errors && Object.keys(errors).length > 0)" class="rounded-md bg-red-50 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Veuillez corriger les erreurs suivantes :
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li v-for="(error, key) in mergedErrors" :key="key">
                                            {{ Array.isArray(error) ? error[0] : error }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form class="space-y-6" @submit.prevent="submitForm">
                        <!-- Photo d'identité upload -->
                        <div class="text-center">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Photo d'identité
                            </label>
                            <div class="flex flex-col items-center">
                                <div v-if="photoPreview" class="mt-2 mb-4">
                                    <img :src="photoPreview" alt="Photo d'identité"
                                        class="h-40 w-40 rounded-full object-cover border-4 border-indigo-100" />
                                </div>
                                <div v-else class="mt-2 mb-4">
                                    <div
                                        class="h-40 w-40 rounded-full bg-gray-100 flex items-center justify-center border-4 border-dashed border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <input type="file" accept="image/*" class="hidden" ref="photoInput"
                                    @input="uploadPhoto($event)" />
                                <div v-if="validationErrors.photo || (errors && errors.photo)" class="mt-1 text-sm text-red-600 text-center">
                                    {{ validationErrors.photo || (errors && errors.photo[0]) }}
                                </div>
                                <button type="button" @click="$refs.photoInput.click()"
                                    class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md transition duration-300">
                                    Télécharger une photo
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">
                                    Nom *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="nom"
                                        v-model="form.nom"
                                        name="nom"
                                        type="text"
                                        @blur="validateField('nom')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.nom || (errors && errors.nom)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.nom || (errors && errors.nom)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.nom || (errors && errors.nom[0]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Prénom(s) -->
                            <div>
                                <label for="prenoms" class="block text-sm font-medium text-gray-700">
                                    Prénom(s) *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="prenoms"
                                        v-model="form.prenoms"
                                        name="prenoms"
                                        type="text"
                                        @blur="validateField('prenoms')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.prenoms || (errors && errors.prenoms)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.prenoms || (errors && errors.prenoms)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.prenoms || (errors && errors.prenoms[0]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Date de naissance -->
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">
                                    Date de Naissance *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="date_naissance"
                                        v-model="form.date_naissance"
                                        name="date_naissance"
                                        type="date"
                                        @blur="validateField('date_naissance')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.date_naissance || (errors && errors.date_naissance)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.date_naissance || (errors && errors.date_naissance)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.date_naissance || (errors && errors.date_naissance[0]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Lieu de naissance -->
                            <div>
                                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">
                                    Lieu de Naissance *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="lieu_naissance"
                                        v-model="form.lieu_naissance"
                                        name="lieu_naissance"
                                        type="text"
                                        @blur="validateField('lieu_naissance')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.lieu_naissance || (errors && errors.lieu_naissance)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.lieu_naissance || (errors && errors.lieu_naissance)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.lieu_naissance || (errors && errors.lieu_naissance[0]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Adresse email *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        @blur="validateField('email')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.email || (errors && errors.email)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.email || (errors && errors.email)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.email || (errors && errors.email[0]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Numéro de CNI -->
                            <div>
                                <label for="numero_cni" class="block text-sm font-medium text-gray-700">
                                    Numéro de CNI *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="numero_cni"
                                        v-model="form.numero_cni"
                                        name="numero_cni"
                                        type="text"
                                        @blur="validateField('numero_cni')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.numero_cni || (errors && errors.numero_cni)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.numero_cni || (errors && errors.numero_cni)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.numero_cni || (errors && errors.numero_cni[0]) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Joindre CNI -->
                        <div>
                            <label for="cni_file" class="block text-sm font-medium text-gray-700">
                                Joindre CNI *
                            </label>
                            <div class="mt-1 flex justify-center rounded-md border-2 border-dashed px-6 pt-5 pb-6"
                                :class="validationErrors.cni_file || (errors && errors.cni_file) ? 'border-red-300' : 'border-gray-300'">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H8m36-12h-4"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 text-center">
                                        <label for="cni_file"
                                            class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Télécharger un fichier</span>
                                            <input id="cni_file" name="cni_file" type="file" class="sr-only"
                                                @input="uploadCNI($event)" />
                                        </label>
                                        <!-- <p class="pl-1">ou glisser-déposer</p> -->
                                    </div>
                                    <p class="text-xs text-gray-500 text-center">PNG, JPG, PDF jusqu'à 10MB</p>
                                    <p v-if="cniFileName" class="text-sm text-indigo-600 mt-2">
                                        {{ cniFileName }}
                                    </p>
                                    <div v-if="validationErrors.cni_file || (errors && errors.cni_file)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.cni_file || (errors && errors.cni_file[0]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Mot de passe *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        name="password"
                                        type="password"
                                        @blur="validateField('password')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.password || (errors && errors.password)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.password || (errors && errors.password)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.password || (errors && errors.password[0]) }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le mot de passe *
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        @blur="validateField('password_confirmation')"
                                        :class="[
                                            'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm',
                                            validationErrors.password_confirmation || (errors && errors.password_confirmation)
                                                ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500'
                                                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                                        ]"
                                    />
                                    <div v-if="validationErrors.password_confirmation || (errors && errors.password_confirmation)" class="mt-1 text-sm text-red-600">
                                        {{ validationErrors.password_confirmation || (errors && errors.password_confirmation[0]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conditions d'utilisation -->
                        <div class="flex items-center">
                            <input
                                id="terms"
                                v-model="form.terms"
                                name="terms"
                                type="checkbox"
                                @change="validateField('terms')"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                :class="validationErrors.terms || (errors && errors.terms) ? 'border-red-300' : ''"
                            />
                            <label for="terms" class="ml-2 block text-sm text-gray-900">
                                J'accepte les
                                <a href="#" class="text-indigo-600 hover:text-indigo-500">
                                    conditions d'utilisation
                                </a>
                                et la
                                <a href="#" class="text-indigo-600 hover:text-indigo-500">
                                    politique de confidentialité
                                </a>
                            </label>
                        </div>
                        <div v-if="validationErrors.terms || (errors && errors.terms)" class="mt-1 text-sm text-red-600">
                            {{ validationErrors.terms || (errors && errors.terms[0]) }}
                        </div>

                        <!-- Bouton de soumission -->
                        <div>
                            <button
                                type="submit"
                                :disabled="form.processing || !isFormValid"
                                :class="[
                                    'w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                                    form.processing || !isFormValid
                                        ? 'bg-indigo-400 cursor-not-allowed'
                                        : 'bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 hover:from-indigo-700 hover:via-purple-700 hover:to-indigo-800'
                                ]"
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ form.processing ? 'Création en cours...' : 'Créer un compte' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const photoInput = ref(null);
const photoPreview = ref(null);
const cniFileName = ref('');

// Object pour stocker les erreurs de validation côté client
const validationErrors = reactive({});

// Correction des noms de champs pour correspondre à la base de données
const form = useForm({
    nom: '',
    prenoms: '',
    email: '',
    password: '',
    password_confirmation: '',
    date_naissance: '',
    lieu_naissance: '',
    numero_cni: '',
    cni_file: null,
    photo: null,
    terms: false
});

const props = defineProps({
    errors: Object,
});

// Combinaison des erreurs côté client et serveur
const mergedErrors = computed(() => {
    const allErrors = {};

    // Ajouter les erreurs de validation côté client
    for (const key in validationErrors) {
        if (validationErrors[key]) {
            allErrors[key] = validationErrors[key];
        }
    }

    // Ajouter les erreurs côté serveur
    if (props.errors) {
        for (const key in props.errors) {
            if (!allErrors[key]) {
                allErrors[key] = Array.isArray(props.errors[key])
                    ? props.errors[key][0]
                    : props.errors[key];
            }
        }
    }

    return allErrors;
});

// Vérifier si le formulaire contient des erreurs
const formHasErrors = computed(() => {
    return Object.values(validationErrors).some(error => error !== '');
});

// Vérifier si le formulaire est valide pour activer/désactiver le bouton
const isFormValid = computed(() => {
    // Vérifie que les champs requis ne sont pas vides
    const requiredFieldsFilled =
        form.nom &&
        form.prenoms &&
        form.email &&
        form.password &&
        form.password_confirmation &&
        form.date_naissance &&
        form.lieu_naissance &&
        form.numero_cni &&
        form.terms;

    // Vérifie qu'il n'y a pas d'erreurs de validation
    const noValidationErrors = !formHasErrors.value;

    return requiredFieldsFilled && noValidationErrors;
});

// Validations automatiques lors des changements de valeurs
watch(() => form.password, () => {
    if (form.password_confirmation) {
        validateField('password_confirmation');
    }
});

// Validation des champs individuels
function validateField(fieldName) {
    switch(fieldName) {
        case 'nom':
            if (!form.nom) {
                validationErrors.nom = 'Le nom est requis';
            } else if (form.nom.length < 2) {
                validationErrors.nom = 'Le nom doit contenir au moins 2 caractères';
            } else {
                validationErrors.nom = '';
            }
            break;

        case 'prenoms':
            if (!form.prenoms) {
                validationErrors.prenoms = 'Le prénom est requis';
            } else if (form.prenoms.length < 2) {
                validationErrors.prenoms = 'Le prénom doit contenir au moins 2 caractères';
            } else {
                validationErrors.prenoms = '';
            }
            break;

        case 'email':
            if (!form.email) {
                validationErrors.email = 'L\'adresse email est requise';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
                validationErrors.email = 'Veuillez saisir une adresse email valide';
            } else {
                validationErrors.email = '';
            }
            break;

        case 'password':
            if (!form.password) {
                validationErrors.password = 'Le mot de passe est requis';
            } else if (form.password.length < 8) {
                validationErrors.password = 'Le mot de passe doit contenir au moins 8 caractères';
            } else if (!/[A-Z]/.test(form.password)) {
                validationErrors.password = 'Le mot de passe doit contenir au moins une majuscule';
            } else if (!/[0-9]/.test(form.password)) {
                validationErrors.password = 'Le mot de passe doit contenir au moins un chiffre';
            } else {
                validationErrors.password = '';
            }

            // Valider également la confirmation si elle est déjà remplie
            if (form.password_confirmation) {
                validateField('password_confirmation');
            }
            break;

        case 'password_confirmation':
            if (!form.password_confirmation) {
                validationErrors.password_confirmation = 'La confirmation du mot de passe est requise';
            } else if (form.password_confirmation !== form.password) {
                validationErrors.password_confirmation = 'Les mots de passe ne correspondent pas';
            } else {
                validationErrors.password_confirmation = '';
            }
            break;

        case 'date_naissance':
            if (!form.date_naissance) {
                validationErrors.date_naissance = 'La date de naissance est requise';
            } else {
                // Vérifier que l'utilisateur a au moins 18 ans
                const birthDate = new Date(form.date_naissance);
                const today = new Date();
                const age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (age < 18 || (age === 18 && monthDiff < 0)) {
                    validationErrors.date_naissance = 'Vous devez avoir au moins 18 ans';
                } else if (birthDate > today) {
                    validationErrors.date_naissance = 'La date de naissance ne peut pas être dans le futur';
                } else {
                    validationErrors.date_naissance = '';
                }
            }
            break;

        case 'lieu_naissance':
            if (!form.lieu_naissance) {
                validationErrors.lieu_naissance = 'Le lieu de naissance est requis';
            } else if (form.lieu_naissance.length < 2) {
                validationErrors.lieu_naissance = 'Le lieu de naissance doit contenir au moins 2 caractères';
            } else {
                validationErrors.lieu_naissance = '';
            }
            break;

        case 'numero_cni':
            if (!form.numero_cni) {
                validationErrors.numero_cni = 'Le numéro de CNI est requis';
            } else if (form.numero_cni.length < 5) {
                validationErrors.numero_cni = 'Le numéro de CNI semble invalide';
            } else {
                validationErrors.numero_cni = '';
            }
            break;

        case 'terms':
            if (!form.terms) {
                validationErrors.terms = 'Vous devez accepter les conditions d\'utilisation';
            } else {
                validationErrors.terms = '';
            }
            break;
    }
}

// Validation des fichiers
function validatePhoto(file) {
    if (!file) {
        validationErrors.photo = 'Une photo d\'identité est requise';
        return false;
    }

    // Vérifier le type de fichier
    if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
        validationErrors.photo = 'La photo doit être au format JPG, PNG ou GIF';
        return false;
    }

    // Vérifier la taille du fichier (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        validationErrors.photo = 'La photo ne doit pas dépasser 5MB';
        return false;
    }

    validationErrors.photo = '';
    return true;
}

function validateCNI(file) {
    if (!file) {
        validationErrors.cni_file = 'Une copie de votre CNI est requise';
        return false;
    }

    // Vérifier le type de fichier
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!allowedTypes.includes(file.type)) {
        validationErrors.cni_file = 'Le fichier doit être au format JPG, PNG ou PDF';
        return false;
    }

    // Vérifier la taille du fichier (max 10MB)
    if (file.size > 10 * 1024 * 1024) {
        validationErrors.cni_file = 'Le fichier ne doit pas dépasser 10MB';
        return false;
    }

    validationErrors.cni_file = '';
    return true;
}

function uploadPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validation du fichier
    if (validatePhoto(file)) {
        form.photo = file;

        // Aperçu de la photo
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        // Réinitialiser en cas d'erreur
        event.target.value = null;
        form.photo = null;
    }
}

function uploadCNI(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validation du fichier
    if (validateCNI(file)) {
        form.cni_file = file;
        cniFileName.value = file.name;
    } else {
        // Réinitialiser en cas d'erreur
        event.target.value = null;
        form.cni_file = null;
        cniFileName.value = '';
    }
}

function validateForm() {
    // Valider tous les champs requis
    const fields = [
        'nom',
        'prenoms',
        'email',
        'password',
        'password_confirmation',
        'date_naissance',
        'lieu_naissance',
        'numero_cni',
        'terms'
    ];

    fields.forEach(field => validateField(field));

    // Valider les fichiers s'ils sont définis
    if (form.photo) {
        validatePhoto(form.photo);
    } else {
        validationErrors.photo = 'Une photo d\'identité est requise';
    }

    if (form.cni_file) {
        validateCNI(form.cni_file);
    } else {
        validationErrors.cni_file = 'Une copie de votre CNI est requise';
    }

    // Vérifier s'il y a des erreurs
    return !Object.values(validationErrors).some(error => error !== '');
}

function submitForm() {
    // Valider tous les champs avant la soumission
    if (!validateForm()) {
        // Scroll vers le haut du formulaire pour montrer les erreurs
        document.querySelector('.bg-red-50')?.scrollIntoView({ behavior: 'smooth' });
        return;
    }

    // Ajouter enctype multipart/form-data pour les fichiers
    form.post('/register', {
        preserveScroll: true,
        forceFormData: true, // Force l'utilisation de FormData pour les fichiers
        onStart: () => {
            console.log('Début de la soumission');
        },
        onProgress: (progress) => {
            console.log('Progression:', progress);
        },
        onSuccess: () => {
            console.log('Succès!');
            // Redirection gérée par le contrôleur
        },
        onError: (errors) => {
            console.log('Erreurs de validation reçues:', errors);

            // Scroll vers la première erreur si nécessaire
            if (Object.keys(errors).length > 0) {
                document.querySelector('.bg-red-50')?.scrollIntoView({ behavior: 'smooth' });
            }
        },
        onFinish: () => {
            console.log('Terminé');
        }
    });
}
</script>
