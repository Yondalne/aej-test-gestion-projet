<template>
    <AuthenticatedLayout title="Liste des projets">
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 py-2">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">Gestion des projets</h2>
                <Link href="/projets/create"
                    class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-md flex items-center justify-center gap-2"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau projet
                </Link>
            </div>
        </template>

        <div class="pb-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl rounded-xl p-6 md:p-8 border border-gray-100">
                    <!-- Filtres de recherche -->
                    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6">
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" id="search" v-model="filters.search"
                                    placeholder="Rechercher par titre ou description..."
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10 pr-4 py-3 bg-gray-50 transition duration-200"
                                    @input="debouncedSearch" />
                            </div>
                        </div>

                        <div v-if="$page.props.auth.user.role === 'admin'">
                            <label for="promoteur"
                                class="block text-sm font-medium text-gray-700 mb-2">Promoteur</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" id="promoteur" v-model="filters.promoteur"
                                    placeholder="Nom du promoteur..."
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10 pr-4 py-3 bg-gray-50 transition duration-200"
                                    @input="debouncedSearch" />
                            </div>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de
                                projet</label>
                            <div class="relative">
                                <select id="type" v-model="filters.type"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-4 pr-10 py-3 bg-gray-50 transition duration-200 appearance-none"
                                    @change="applyFilters">
                                    <option value="">Tous les types</option>
                                    <option value="En Développement">En Développement</option>
                                    <option value="En Création">En Création</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <div class="relative">
                                <select id="statut" v-model="filters.statut"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-4 pr-10 py-3 bg-gray-50 transition duration-200 appearance-none"
                                    @change="applyFilters">
                                    <option value="">Tous les statuts</option>
                                    <option value="En Attente">En Attente</option>
                                    <option value="Validé">Validé</option>
                                    <option value="Rejeté">Rejeté</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-center md:justify-end space-x-3 lg:col-span-1">
                            <button @click="downloadPDF"
                                class="flex items-center px-4 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                PDF
                            </button>
                            <button @click="downloadExcel"
                                class="flex items-center px-4 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Excel
                            </button>
                        </div>
                    </div>

                    <!-- Tableau des projets -->
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('titre')">
                                            <div class="flex items-center space-x-1">
                                                <span>Titre</span>
                                                <span v-if="sortColumn === 'titre'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th v-if="$page.props.auth.user.role === 'admin'" scope="col"
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('user')">
                                            <div class="flex items-center space-x-1">
                                                <span>Promoteur</span>
                                                <span v-if="sortColumn === 'user'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('type')">
                                            <div class="flex items-center space-x-1">
                                                <span>Type</span>
                                                <span v-if="sortColumn === 'type'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('forme_juridique')">
                                            <div class="flex items-center space-x-1">
                                                <span>Forme juridique</span>
                                                <span v-if="sortColumn === 'forme_juridique'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('statut')">
                                            <div class="flex items-center space-x-1">
                                                <span>Statut</span>
                                                <span v-if="sortColumn === 'statut'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer transition duration-200 hover:bg-gray-100"
                                            @click="sortBy('created_at')">
                                            <div class="flex items-center space-x-1">
                                                <span>Date</span>
                                                <span v-if="sortColumn === 'created_at'" class="text-indigo-600">
                                                    <svg v-if="sortDirection === 'asc'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>

                                        <th scope="col" class="relative px-6 py-4">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="projet in paginatedProjets" :key="projet.id"
                                        class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">{{ projet.titre }}</div>
                                            <div class="text-sm text-gray-500 mt-1">{{ truncate(projet.description, 50)
                                                }}</div>
                                        </td>

                                        <td v-if="$page.props.auth.user.role === 'admin'" class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ projet.user.nom }} {{
                                                projet.user.prenoms }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-700">{{ projet.type }}</div>
                                        </td>

                                        <td class="hidden md:table-cell px-6 py-4">
                                            <div class="text-sm font-medium text-gray-700">{{ projet.forme_juridique }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="{
                                                    'bg-yellow-100 text-yellow-800 border border-yellow-200': projet.statut === 'En Attente',
                                                    'bg-green-100 text-green-800 border border-green-200': projet.statut === 'Validé',
                                                    'bg-red-100 text-red-800 border border-red-200': projet.statut === 'Rejeté'
                                                }">
                                                {{ projet.statut }}
                                            </span>
                                        </td>

                                        <td class="hidden md:table-cell px-6 py-4">
                                            <div class="text-sm text-gray-700">{{ formatDate(projet.created_at) }}</div>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end space-x-3">
                                                <Link :href="`/projets/${projet.id}`"
                                                    class="text-indigo-600 hover:text-indigo-900 transition duration-150 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </Link>
                                                <Link v-if="$page.props.auth.user.role === 'promoteur' && projet.statut !== 'Validé'"
                                                    :href="`/projets/${projet.id}/edit`"
                                                    class="text-amber-600 hover:text-amber-900 transition duration-150 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="filteredProjets.length === 0">
                                        <td :colspan="$page.props.auth.user.role === 'admin' ? 7 : 6"
                                            class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-10 w-10 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p class="text-lg font-medium">Aucun projet trouvé</p>
                                                <p class="text-sm text-gray-400 mt-1">Essayez de modifier vos critères
                                                    de
                                                    recherche</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 mb-4 md:mb-0">
                            Affichage {{ startItem }}-{{ endItem }} sur {{ filteredProjets.length }} projets
                        </div>
                        <div class="flex space-x-2">
                            <button @click="prevPage" :disabled="currentPage === 1"
                                class="px-4 py-2 rounded-lg border text-sm font-medium transition duration-150"
                                :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 hover:bg-gray-50'">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Précédent
                                </span>
                            </button>

                            <div class="hidden md:flex space-x-2">
                                <button v-for="page in displayedPages" :key="page" @click="goToPage(page)"
                                    class="px-4 py-2 rounded-lg border font-medium text-sm transition duration-150"
                                    :class="currentPage === page ? 'bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-700' : 'text-gray-700 border-gray-300 hover:bg-gray-50'">
                                    {{ page }}
                                </button>
                            </div>

                            <button @click="nextPage" :disabled="currentPage === totalPages"
                                class="px-4 py-2 rounded-lg border text-sm font-medium transition duration-150"
                                :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 hover:bg-gray-50'">
                                <span class="flex items-center">
                                    Suivant
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
/* Styles personnalisés pour améliorer davantage l'interface */

/* Animation subtile pour les boutons */
button,
a {
    transition: all 0.2s ease;
}

/* Style pour l'ombre de la carte principale */
.shadow-xl {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
}

/* Style pour les boutons actifs de pagination */
.bg-indigo-600.text-white {
    box-shadow: 0 2px 5px 0 rgba(79, 70, 229, 0.3);
}

/* Amélioration des cellules du tableau sur mobile */
@media (max-width: 640px) {
    table {
        table-layout: fixed;
    }

    td,
    th {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}

/* Animation d'apparition pour les boutons d'action */
button:hover svg,
a:hover svg {
    transform: scale(1.1);
}

/* Animation pour le modal */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.modal-enter,
.modal-leave-to {
    opacity: 0;
}
</style>

<script setup>
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';
import { ref, computed, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import debounce from 'lodash/debounce';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    projets: {
        type: Object,
        default: () => ({
            data: [],
            meta: {
                current_page: 1,
                last_page: 1,
                total: 0,
            },
        }),
    },
});

// État des filtres
const filters = ref({
    search: '',
    promoteur: '',
    type: '',
    statut: '',
});

// État du tri
const sortColumn = ref('created_at');
const sortDirection = ref('desc');

// État de la pagination
const itemsPerPage = 5;
const currentPage = ref(1);


// Debouncage de la recherche
const debouncedSearch = debounce(() => {
    applyFilters();
}, 300);

// Filtrage des projets
const filteredProjets = computed(() => {
    return props.projets.data.filter(projet => {
        const matchSearch = !filters.value.search ||
            projet.titre.toLowerCase().includes(filters.value.search.toLowerCase()) ||
            (projet.description && projet.description.toLowerCase().includes(filters.value.search.toLowerCase()));

        const matchPromoteur = !filters.value.promoteur ||
            `${projet.user.nom} ${projet.user.prenoms}`.toLowerCase().includes(filters.value.promoteur.toLowerCase());

        const matchType = !filters.value.type || projet.type === filters.value.type;

        const matchStatut = !filters.value.statut || projet.statut === filters.value.statut;

        return matchSearch && matchPromoteur && matchType && matchStatut;
    }).sort((a, b) => {
        if (sortColumn.value === 'user') {
            const nameA = `${a.user.nom} ${a.user.prenoms}`.toLowerCase();
            const nameB = `${b.user.nom} ${b.user.prenoms}`.toLowerCase();
            return sortDirection.value === 'asc'
                ? nameA.localeCompare(nameB)
                : nameB.localeCompare(nameA);
        } else {
            const valA = a[sortColumn.value];
            const valB = b[sortColumn.value];

            if (typeof valA === 'string' && typeof valB === 'string') {
                return sortDirection.value === 'asc'
                    ? valA.localeCompare(valB)
                    : valB.localeCompare(valA);
            } else {
                return sortDirection.value === 'asc'
                    ? valA - valB
                    : valB - valA;
            }
        }
    });
});

// Calcul des projets paginés
const paginatedProjets = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return filteredProjets.value.slice(startIndex, endIndex);
});

// Calcul du nombre total de pages
const totalPages = computed(() => {
    return Math.ceil(filteredProjets.value.length / itemsPerPage);
});

// Calcul des pages à afficher
const displayedPages = computed(() => {
    const maxVisiblePages = 5;
    if (totalPages.value <= maxVisiblePages) {
        return Array.from({ length: totalPages.value }, (_, i) => i + 1);
    }

    let startPage = Math.max(1, currentPage.value - Math.floor(maxVisiblePages / 2));
    let endPage = startPage + maxVisiblePages - 1;

    if (endPage > totalPages.value) {
        endPage = totalPages.value;
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
});

// Calcul des indices pour l'affichage "X-Y sur Z éléments"
const startItem = computed(() => {
    if (filteredProjets.value.length === 0) return 0;
    return (currentPage.value - 1) * itemsPerPage + 1;
});

const endItem = computed(() => {
    if (filteredProjets.value.length === 0) return 0;
    const end = currentPage.value * itemsPerPage;
    return end > filteredProjets.value.length ? filteredProjets.value.length : end;
});

// Méthodes de pagination
function goToPage(page) {
    currentPage.value = page;
}

function nextPage() {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}

function prevPage() {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
}

// Méthode de tri
function sortBy(column) {
    if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortDirection.value = 'asc';
    }
}

// Méthode pour appliquer les filtres
function applyFilters() {
    // Reset page to 1 when filters change
    currentPage.value = 1;
}

// Utilitaires
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
}

function truncate(str, length) {
    if (!str) return '';
    return str.length > length ? str.substring(0, length) + '...' : str;
}

// Méthodes pour le téléchargement
function downloadPDF() {
    const doc = new jsPDF();

    // Titre du document
    doc.setFontSize(16);
    doc.text('Liste des projets', 14, 15);
    doc.setFontSize(10);

    // Information sur les filtres appliqués
    let filterText = 'Filtres appliqués: ';
    if (filters.value.search) filterText += `Recherche: ${filters.value.search}, `;
    if (filters.value.promoteur) filterText += `Promoteur: ${filters.value.promoteur}, `;
    if (filters.value.type) filterText += `Type: ${filters.value.type}, `;
    if (filters.value.statut) filterText += `Statut: ${filters.value.statut}, `;

    // Supprimer la dernière virgule si elle existe
    filterText = filterText.endsWith(', ') ? filterText.slice(0, -2) : filterText;

    // Si aucun filtre n'est appliqué
    if (filterText === 'Filtres appliqués: ') {
        filterText = 'Aucun filtre appliqué';
    }

    doc.text(filterText, 14, 25);

    // Définir les colonnes du tableau
    let columns = [];
    let isAdmin = false;

    // Vérifier si l'utilisateur est admin
    try {
        isAdmin = window.Inertia.page.props.auth.user.role === 'admin';
    } catch (e) {
        isAdmin = false;
    }

    columns = [
        { header: 'Titre', dataKey: 'titre' },
    ];

    if (isAdmin) {
        columns.push({ header: 'Promoteur', dataKey: 'promoteur' });
    }

    columns = [
        ...columns,
        { header: 'Type', dataKey: 'type' },
        { header: 'Forme juridique', dataKey: 'forme_juridique' },
        { header: 'Statut', dataKey: 'statut' },
        { header: 'Date de création', dataKey: 'created_at' }
    ];

    // Préparer les données
    const data = filteredProjets.value.map(projet => {
        let row = {
            titre: projet.titre,
            type: projet.type,
            forme_juridique: projet.forme_juridique,
            statut: projet.statut,
            created_at: formatDate(projet.created_at)
        };

        if (isAdmin) {
            row.promoteur = `${projet.user.nom} ${projet.user.prenoms}`;
        }

        return row;
    });

    // Générer le tableau avec autoTable comme fonction indépendante
    autoTable(doc, {
        head: [columns.map(col => col.header)],
        body: data.map(item => columns.map(col => item[col.dataKey])),
        startY: 30,
        headStyles: { fillColor: [63, 81, 181] },
        alternateRowStyles: { fillColor: [240, 240, 240] },
        margin: { top: 30 }
    });

    // Ajouter la date de génération
    const dateGeneration = new Date();
    doc.setFontSize(8);
    doc.text(`Document généré le ${formatDate(dateGeneration.toISOString())}`, 14, doc.internal.pageSize.height - 10);

    // Télécharger le PDF
    doc.save('projets.pdf');
}

function downloadExcel() {
    // Définir si l'utilisateur est admin
    let isAdmin = false;
    try {
        isAdmin = window.Inertia.page.props.auth.user.role === 'admin';
    } catch (e) {
        isAdmin = false;
    }

    // Préparer les données
    const data = filteredProjets.value.map(projet => {
        let row = {
            'Titre': projet.titre,
            'Description': projet.description,
            'Type': projet.type,
            'Forme juridique': projet.forme_juridique,
            'Statut': projet.statut,
            'Date de création': formatDate(projet.created_at)
        };

        if (isAdmin) {
            row['Promoteur'] = `${projet.user.nom} ${projet.user.prenoms}`;
        }

        return row;
    });

    // Créer une feuille de calcul
    const worksheet = XLSX.utils.json_to_sheet(data);

    // Créer un classeur
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Projets');

    // Ajuster la largeur des colonnes
    const colWidths = Object.keys(data[0] || {}).map(key => ({ wch: Math.max(key.length, 15) }));
    worksheet['!cols'] = colWidths;

    // Générer le fichier Excel et le télécharger
    XLSX.writeFile(workbook, 'projets.xlsx');
}
</script>
