<template>
    <AuthenticatedLayout title="Modifier un projet">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier le projet
            </h2>
        </template>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <!-- Affichage des erreurs globales -->
                    <div v-if="validationHasErrors || (form.errors && Object.keys(form.errors).length > 0)"
                         class="mb-6 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Veuillez corriger les erreurs suivantes :
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li v-for="(error, key) in allErrors" :key="key">
                                            {{ error }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <a href="/projets"
                            class="text-indigo-600 hover:text-indigo-900 flex items-center transition duration-200"
                            @click.prevent="$inertia.visit('/projets')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span class="border-b border-indigo-600 border-dashed pb-0.5">Retour à la liste</span>
                        </a>
                    </div>

                    <form @submit.prevent="submitForm" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Titre du projet -->
                            <div class="col-span-2">
                                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre du projet <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </span>
                                    <input id="titre" type="text" v-model="form.titre"
                                        @blur="validateField('titre')"
                                        :class="[
                                            'mt-2 pl-10 block w-full rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 py-3',
                                            validationErrors.titre || form.errors.titre
                                                ? 'border-red-300 pr-10'
                                                : 'border-gray-300'
                                        ]"
                                        placeholder="Entrez le titre du projet" />
                                    <div v-if="validationErrors.titre || form.errors.titre"
                                         class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.titre || form.errors.titre" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.titre || form.errors.titre }}
                                </div>
                            </div>

                            <!-- Description du projet -->
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <div class="relative">
                                    <textarea id="description" v-model="form.description"
                                        @blur="validateField('description')"
                                        :class="[
                                            'mt-2 block w-full ps-4 rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 py-3',
                                            validationErrors.description || form.errors.description
                                                ? 'border-red-300'
                                                : 'border-gray-300'
                                        ]"
                                        rows="4" placeholder="Décrivez le projet en détail..."></textarea>
                                    <div v-if="validationErrors.description || form.errors.description"
                                         class="absolute top-2 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.description || form.errors.description" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.description || form.errors.description }}
                                </div>
                            </div>

                            <!-- Type de projet -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de projet <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                        </svg>
                                    </span>
                                    <select id="type" v-model="form.type"
                                        @blur="validateField('type')"
                                        :class="[
                                            'mt-2 pl-10 block w-full rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 appearance-none py-3',
                                            validationErrors.type || form.errors.type
                                                ? 'border-red-300'
                                                : 'border-gray-300'
                                        ]">
                                        <option value="" disabled>Sélectionner un type</option>
                                        <option value="En Développement">En Développement</option>
                                        <option value="En Création">En Création</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.type || form.errors.type" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.type || form.errors.type }}
                                </div>
                            </div>

                            <!-- Forme juridique -->
                            <div>
                                <label for="forme_juridique" class="block text-sm font-medium text-gray-700 mb-2">
                                    Forme juridique <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </span>
                                    <select id="forme_juridique" v-model="form.forme_juridique"
                                        @blur="validateField('forme_juridique')"
                                        :class="[
                                            'mt-2 pl-10 block w-full rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 appearance-none py-3',
                                            validationErrors.forme_juridique || form.errors.forme_juridique
                                                ? 'border-red-300'
                                                : 'border-gray-300'
                                        ]">
                                        <option value="" disabled>Sélectionner une forme juridique</option>
                                        <option value="PME & Startup">PME & Startup</option>
                                        <option value="Grandes Entreprises">Grandes Entreprises</option>
                                        <option value="Administration Publiques">Administration Publiques</option>
                                        <option value="Cabinets de Recrutement">Cabinets de Recrutement</option>
                                        <option value="Organisme de Recrutement">Organisme de Recrutement</option>
                                        <option value="Structure Accompagnement">Structure Accompagnement</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.forme_juridique || form.errors.forme_juridique" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.forme_juridique || form.errors.forme_juridique }}
                                </div>
                            </div>

                            <!-- Statut (uniquement visible pour les administrateurs) -->
                            <div v-if="$page.props.auth.user.role === 'admin'">
                                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                    Statut <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <select id="statut" v-model="form.statut"
                                        @blur="validateField('statut')"
                                        :class="[
                                            'mt-2 pl-10 block w-full rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 appearance-none py-3',
                                            validationErrors.statut || form.errors.statut
                                                ? 'border-red-300'
                                                : 'border-gray-300'
                                        ]">
                                        <option value="En Attente">En Attente</option>
                                        <option value="Validé">Validé</option>
                                        <option value="Rejeté">Rejeté</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.statut || form.errors.statut" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.statut || form.errors.statut }}
                                </div>
                            </div>

                            <!-- Justification de rejet (uniquement visible pour les administrateurs et lorsque le statut est "Rejeté") -->
                            <div v-if="$page.props.auth.user.role === 'admin' && form.statut === 'Rejeté'"
                                class="col-span-2">
                                <label for="justification_rejet" class="block text-sm font-medium text-gray-700 mb-2">
                                    Justification du rejet <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <textarea id="justification_rejet" v-model="form.justification_rejet"
                                        @blur="validateField('justification_rejet')"
                                        :class="[
                                            'mt-2 block w-full pl-10 rounded-lg border shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 py-3',
                                            validationErrors.justification_rejet || form.errors.justification_rejet
                                                ? 'border-red-300'
                                                : 'border-gray-300'
                                        ]"
                                        rows="3" placeholder="Veuillez expliquer les raisons du rejet..."></textarea>
                                    <div v-if="validationErrors.justification_rejet || form.errors.justification_rejet"
                                         class="absolute top-2 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="validationErrors.justification_rejet || form.errors.justification_rejet" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.justification_rejet || form.errors.justification_rejet }}
                                </div>
                            </div>

                            <!-- Plan d'affaires actuel -->
                            <div class="col-span-2" v-if="projet.plan_affaire_path">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Plan d'affaires
                                    actuel</label>
                                <div
                                    class="mt-2 flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 transition duration-200">
                                    <svg class="h-8 w-8 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">Document PDF</h3>
                                        <p class="text-sm text-gray-500">Plan d'affaires actuel du projet</p>
                                    </div>
                                    <a :href="`/storage/${projet.plan_affaire_path}`" target="_blank"
                                        class="ml-4 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md text-sm font-medium hover:bg-indigo-200 transition duration-200 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Visualiser
                                    </a>
                                </div>
                            </div>

                            <!-- Nouveau plan d'affaires (optionnel) -->
                            <div class="col-span-2">
                                <label for="plan_affaire" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau plan d'affaires (optionnel)
                                </label>
                                <div
                                    :class="[
                                        'mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-colors duration-200 bg-gray-50 cursor-pointer',
                                        validationErrors.plan_affaire || form.errors.plan_affaire
                                            ? 'border-red-300 hover:border-red-400'
                                            : 'border-gray-300 hover:border-indigo-400'
                                    ]"
                                    @click="$refs.fileInput.click()"
                                    @dragover.prevent
                                    @drop.prevent="handleFileDrop">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none px-3 py-2 shadow-sm border border-gray-300"
                                                @click.stop>
                                                <span>Télécharger un nouveau fichier</span>
                                                <input ref="fileInput" id="plan_affaire_file" type="file"
                                                    class="sr-only" @input="handleFileInput" accept=".pdf" />
                                            </label>
                                            <p class="pl-2 pt-1">ou glisser-déposer</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PDF uniquement (max. 10Mo)
                                        </p>
                                        <div v-if="form.plan_affaire"
                                            class="flex items-center justify-center p-2 mt-2 bg-indigo-50 rounded-lg text-indigo-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm truncate max-w-xs">{{ form.plan_affaire.name }}</span>
                                            <button @click.stop.prevent="removeFile"
                                                class="ml-2 text-indigo-500 hover:text-indigo-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="validationErrors.plan_affaire || form.errors.plan_affaire" class="text-red-500 text-sm mt-1">
                                    {{ validationErrors.plan_affaire || form.errors.plan_affaire }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit"
                                :class="[
                                    'group relative px-6 pe-10 py-3 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 overflow-hidden',
                                    form.processing || !isFormValid
                                        ? 'bg-indigo-400 cursor-not-allowed'
                                        : 'bg-indigo-600 hover:bg-indigo-700'
                                ]"
                                :disabled="form.processing || !isFormValid">
                                <span
                                    class="absolute right-0 inset-y-0 flex items-center pr-3 transition-opacity group-hover:opacity-70">
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span>{{ form.processing ? 'Enregistrement...' : 'Enregistrer les modifications' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Référence pour l'input de fichier
const fileInput = ref(null);

// Objet pour stocker les erreurs de validation côté client
const validationErrors = reactive({});

// Propriétés du composant
const props = defineProps({
    projet: {
        type: Object,
        required: true
    }
});

// Formulaire avec validation et données existantes
const form = useForm({
    titre: props.projet.titre,
    description: props.projet.description || '',
    type: props.projet.type,
    forme_juridique: props.projet.forme_juridique,
    statut: props.projet.statut,
    justification_rejet: props.projet.justification_rejet || '',
    plan_affaire: null, // Nouveau fichier (optionnel)
    _method: 'put', // Pour simuler une requête PUT avec FormData
});

// Vérifier si le formulaire contient des erreurs de validation
const validationHasErrors = computed(() => {
    return Object.values(validationErrors).some(error => error !== '');
});

// Toutes les erreurs (validation client + serveur)
const allErrors = computed(() => {
    const errors = {};

    // Ajouter les erreurs de validation côté client
    for (const key in validationErrors) {
        if (validationErrors[key]) {
            errors[key] = validationErrors[key];
        }
    }

    // Ajouter les erreurs du serveur qui ne sont pas déjà présentes côté client
    for (const key in form.errors) {
        if (form.errors[key] && !errors[key]) {
            errors[key] = form.errors[key];
        }
    }

    return errors;
});

// Vérifier si le formulaire est valide
const isFormValid = computed(() => {
    // Vérifie que les champs obligatoires sont remplis
    const requiredFieldsFilled = form.titre && form.type && form.forme_juridique;

    // Vérifier la justification du rejet si statut est "Rejeté"
    const justificationRequired = form.statut === 'Rejeté';
    if (justificationRequired && !form.justification_rejet) {
        return false;
    }

    // Vérifie qu'il n'y a pas d'erreurs de validation
    const noValidationErrors = !validationHasErrors.value;

    return requiredFieldsFilled && noValidationErrors;
});

// Observer les changements de statut pour la validation dynamique
watch(() => form.statut, (newVal) => {
    if (newVal === 'Rejeté') {
        validateField('justification_rejet');
    }
});

// Fonction de validation des champs
function validateField(fieldName) {
    switch(fieldName) {
        case 'titre':
            if (!form.titre) {
                validationErrors.titre = 'Le titre du projet est requis';
            } else if (form.titre.length < 3) {
                validationErrors.titre = 'Le titre doit contenir au moins 3 caractères';
            } else if (form.titre.length > 100) {
                validationErrors.titre = 'Le titre ne doit pas dépasser 100 caractères';
            } else {
                validationErrors.titre = '';
            }
            break;

        case 'description':
            if (form.description && form.description.length > 1000) {
                validationErrors.description = 'La description ne doit pas dépasser 1000 caractères';
            } else {
                validationErrors.description = '';
            }
            break;

        case 'type':
            if (!form.type) {
                validationErrors.type = 'Le type de projet est requis';
            } else {
                validationErrors.type = '';
            }
            break;

        case 'forme_juridique':
            if (!form.forme_juridique) {
                validationErrors.forme_juridique = 'La forme juridique est requise';
            } else {
                validationErrors.forme_juridique = '';
            }
            break;

        case 'statut':
            if (!form.statut) {
                validationErrors.statut = 'Le statut est requis';
            } else {
                validationErrors.statut = '';

                // Si le statut est "Rejeté", valider également la justification
                if (form.statut === 'Rejeté') {
                    validateField('justification_rejet');
                }
            }
            break;

        case 'justification_rejet':
            if (form.statut === 'Rejeté') {
                if (!form.justification_rejet) {
                    validationErrors.justification_rejet = 'La justification du rejet est requise';
                } else if (form.justification_rejet.length < 10) {
                    validationErrors.justification_rejet = 'La justification doit contenir au moins 10 caractères';
                } else {
                    validationErrors.justification_rejet = '';
                }
            } else {
                validationErrors.justification_rejet = '';
            }
            break;
    }
}

// Valider le fichier PDF
function validateFile(file) {
    if (!file) {
        validationErrors.plan_affaire = '';
        return true; // Le fichier est optionnel pour la mise à jour
    }

    // Vérifier le type de fichier
    if (file.type !== 'application/pdf') {
        validationErrors.plan_affaire = 'Le fichier doit être au format PDF';
        return false;
    }

    // Vérifier la taille du fichier (max 10MB)
    if (file.size > 10 * 1024 * 1024) {
        validationErrors.plan_affaire = 'Le fichier ne doit pas dépasser 10MB';
        return false;
    }

    validationErrors.plan_affaire = '';
    return true;
}

// Fonction pour valider tout le formulaire
function validateForm() {
    validateField('titre');
    validateField('description');
    validateField('type');
    validateField('forme_juridique');

    // Valider le statut et la justification si l'utilisateur est admin
    if (window?.$page?.props?.auth?.user?.role === 'admin') {
        validateField('statut');
        if (form.statut === 'Rejeté') {
            validateField('justification_rejet');
        }
    }

    // Valider le fichier s'il est défini
    if (form.plan_affaire) {
        validateFile(form.plan_affaire);
    }

    return !validationHasErrors.value;
}

// Gestion de l'upload de fichier via l'input
function handleFileInput(event) {
    const file = event.target.files[0];
    if (file) {
        if (validateFile(file)) {
            form.plan_affaire = file;
        } else {
            // Réinitialiser l'input de fichier en cas d'erreur
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        }
    }
}

// Gestion du glisser-déposer
function handleFileDrop(event) {
    const droppedFiles = event.dataTransfer.files;
    if (droppedFiles.length > 0) {
        const file = droppedFiles[0];
        if (validateFile(file)) {
            form.plan_affaire = file;
        }
    }
}

// Supprimer le fichier sélectionné
function removeFile() {
    form.plan_affaire = null;
    validationErrors.plan_affaire = '';
    if (fileInput.value) {
        fileInput.value.value = '';
    }
}

// Soumettre le formulaire
function submitForm() {
    // Valider le formulaire côté client avant soumission
    if (!validateForm()) {
        // Faire défiler jusqu'à la première erreur
        document.querySelector('.bg-red-50')?.scrollIntoView({ behavior: 'smooth' });
        return;
    }

    form.post(`/projets/${props.projet.id}`, {
        forceFormData: true, // Nécessaire pour l'upload de fichiers
        preserveScroll: true,
        onSuccess: () => {
            // Le message de succès sera géré par un listener global
        },
        onError: () => {
            // Faire défiler jusqu'à la première erreur
            document.querySelector('.bg-red-50')?.scrollIntoView({ behavior: 'smooth' });
        }
    });
}
</script>
