<template>
    <AuthenticatedLayout title="Détails du projet">
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Détails du projet
                </h2>
                <!-- Badge de statut flottant à droite sur desktop -->
                <div class="md:ml-4 mt-2 md:mt-0">
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium shadow-sm" :class="{
                        'bg-yellow-100 text-yellow-800 border border-yellow-200': projet.statut === 'En Attente',
                        'bg-green-100 text-green-800 border border-green-200': projet.statut === 'Validé',
                        'bg-red-100 text-red-800 border border-red-200': projet.statut === 'Rejeté'
                    }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" :class="{
                                'text-yellow-500': projet.statut === 'En Attente',
                                'text-green-500': projet.statut === 'Validé',
                                'text-red-500': projet.statut === 'Rejeté'
                            }">
                            <path v-if="projet.statut === 'En Attente'" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path v-if="projet.statut === 'Validé'" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path v-if="projet.statut === 'Rejeté'" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ projet.statut }}
                    </div>
                </div>
            </div>
        </template>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Barre d'actions flottante -->
                <div
                    class="sticky top-16 z-10 py-3 bg-white shadow-md rounded-lg mb-6 px-4 flex items-center justify-between transition-all duration-200 ease-in-out">
                    <Link href="/projets"
                        class="text-indigo-600 hover:text-indigo-900 flex items-center transition-all duration-200 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="border-b border-dashed border-indigo-300 pb-0.5">Retour à la liste</span>
                    </Link>

                    <div class="flex flex-wrap gap-2 justify-end">
                        <!-- Menu dropdown pour les actions (visible sur mobile) -->
                        <div class="relative sm:hidden">
                            <button @click="showActionMenu = !showActionMenu"
                                class="flex items-center justify-center p-2 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>

                            <!-- Menu déroulant -->
                            <div v-if="showActionMenu"
                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1" role="none">
                                    <a :href="`/projets/export-pdf/${projet.id}`"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-purple-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Exporter PDF
                                    </a>
                                    <Link
                                        v-if="$page.props.auth.user.id === projet.user_id && projet.statut !== 'Validé'"
                                        :href="`/projets/${projet.id}/edit`"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-yellow-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                    </Link>
                                    <button v-if="$page.props.auth.user.id === projet.user_id" @click="confirmDelete"
                                        class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action (visibles sur desktop) -->
                        <a :href="`/projets/export-pdf/${projet.id}`"
                            class="hidden sm:inline-flex items-center px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-xs sm:text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>PDF</span>
                        </a>
                        <Link v-if="$page.props.auth.user.id === projet.user_id && projet.statut !== 'Validé'"
                            :href="`/projets/${projet.id}/edit`"
                            class="hidden sm:inline-flex items-center px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-xs sm:text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Modifier</span>
                        </Link>
                        <button v-if="$page.props.auth.user.id === projet.user_id" @click="confirmDelete"
                            class="hidden sm:inline-flex items-center px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-xs sm:text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Supprimer</span>
                        </button>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Entête du projet -->
                    <div class="relative overflow-hidden">
                        <!-- Bannière colorée dynamique selon le statut -->
                        <div class="absolute top-0 left-0 right-0 h-28 opacity-10" :class="{
                            'bg-yellow-300': projet.statut === 'En Attente',
                            'bg-green-300': projet.statut === 'Validé',
                            'bg-red-300': projet.statut === 'Rejeté'
                        }">
                        </div>

                        <div class="relative px-6 pt-8 pb-4">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 break-words">{{ projet.titre }}
                            </h1>
                            <div class="flex flex-wrap items-center text-sm text-gray-500 gap-x-6 gap-y-1">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Créé le {{ formatDate(projet.created_at) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Par {{ projet.user.nom }} {{ projet.user.prenoms }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span>Mise à jour le {{ formatDate(projet.updated_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Séparateur -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Contenu du projet -->
                    <div class="p-6">
                        <!-- Description -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Description
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <div class="prose max-w-none text-gray-700">
                                    <p>{{ projet.description || 'Aucune description fournie.' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informations détaillées et documents -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Détails du projet -->
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="bg-gray-50 px-4 py-3 rounded-t-lg border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Détails
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="space-y-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-500 uppercase tracking-wider">Type de
                                                projet</span>
                                            <span class="mt-1 font-medium text-gray-800">{{ projet.type }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-500 uppercase tracking-wider">Forme
                                                juridique</span>
                                            <span class="mt-1 font-medium text-gray-800">{{ projet.forme_juridique
                                                }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs text-gray-500 uppercase tracking-wider">Identifiant</span>
                                            <span class="mt-1 font-medium text-gray-800">#{{ projet.id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plan d'affaires -->
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="bg-gray-50 px-4 py-3 rounded-t-lg border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Plan d'affaires
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-50 p-3 rounded-lg">
                                            <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">Document PDF</h4>
                                            <p class="text-xs text-gray-500 mt-1">Plan d'affaires détaillé du projet</p>
                                        </div>
                                        <a :href="`/projets/${projet.id}/download`"
                                            class="ml-4 flex-shrink-0 inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Justification du rejet (si rejeté) -->
                        <div v-if="projet.statut === 'Rejeté' && projet.justification_rejet" class="mb-8">
                            <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Justification du rejet</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>{{ projet.justification_rejet }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions administrateur -->
                        <div v-if="$page.props.auth.user.role === 'admin' && projet.statut === 'En Attente'"
                            class="flex flex-col sm:flex-row gap-3 sm:justify-center">
                            <button @click="validerProjet"
                                class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Valider le projet
                            </button>
                            <button @click="showRejetModal = true"
                                class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-md transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Rejeter le projet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation de suppression -->
        <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showDeleteModal"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 flex items-center justify-center overflow-y-auto">
                <div class="fixed inset-0" @click="showDeleteModal = false"></div>

                <Transition enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="relative bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                        <div class="bg-white p-6">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Confirmation de suppression
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est
                                            irréversible.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button @click="deleteProjet" type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                                    Supprimer
                                </button>
                                <button @click="showDeleteModal = false" type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition-all duration-200">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>

        <!-- Modal de rejet de projet -->
        <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showRejetModal"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 flex items-center justify-center overflow-y-auto">
                <div class="fixed inset-0" @click="showRejetModal = false"></div>

                <Transition enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="relative bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                        <div class="bg-white p-6">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Justification du rejet
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Veuillez fournir une justification pour le rejet de ce projet.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="justification_rejet" class="block text-sm font-medium text-gray-700">
                                    Motif du rejet <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <textarea id="justification_rejet" v-model="form.justification_rejet" rows="4"
                                        :class="[
                                            'block w-full border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm p-3',
                                            form.errors.justification_rejet ? 'border-red-400 pr-10 text-red-900 placeholder-red-400 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300'
                                        ]" placeholder="Expliquez en détail les raisons du rejet..."></textarea>
                                    <div v-if="form.errors.justification_rejet"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-start pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500 mt-2" fill="currentColor" viewBox="0 0 20 20"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p v-if="form.errors.justification_rejet" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.justification_rejet }}
                                </p>
                            </div>

                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                <button @click="submitRejet" :disabled="form.processing" :class="[
                                    'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:col-start-2 sm:text-sm transition-all duration-200',
                                    form.processing ? 'bg-red-400 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                                ]">
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Confirmer le rejet
                                </button>
                                <button @click="showRejetModal = false" type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm transition-all duration-200">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Transition } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    projet: {
        type: Object,
        required: true
    }
});

// État pour les modals et le menu
const showDeleteModal = ref(false);
const showRejetModal = ref(false);
const showActionMenu = ref(false);

// Fermer le menu d'action quand on clique sur document
document.addEventListener('click', () => {
    showActionMenu.value = false;
});

// Formulaire pour le rejet
const form = useForm({
    justification_rejet: '',
});

// Méthodes pour la suppression
function confirmDelete() {
    showDeleteModal.value = true;
    showActionMenu.value = false;
}

function deleteProjet() {
    router.delete(`/projets/${props.projet.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
}

// Méthodes pour la validation et le rejet
function validerProjet() {
    router.patch(`/projets/${props.projet.id}/valider`, {}, {
        onSuccess: () => {
            // Le message flash sera affiché par le ToastListener
        },
        onError: (errors) => {
            // Erreurs gérées par le ToastListener
        },
    });
}

function submitRejet() {
    form.patch(`/projets/${props.projet.id}/rejeter`, {
        onSuccess: () => {
            showRejetModal.value = false;
            form.reset();
        },
        onError: () => {
            // Erreurs gérées automatiquement par Inertia
        },
    });
}

// Utilitaires
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(date);
}
</script>

<style scoped>
/* Animation de survol pour les boutons d'action */
.action-button {
    transition: all 0.2s;
}

.action-button:hover {
    transform: translateY(-1px);
}

/* Animation de la barre d'actions lors du défilement */
.sticky {
    transition: box-shadow 0.3s ease-in-out;
}

/* Animation des transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
