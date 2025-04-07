<template>
    <AuthenticatedLayout title="Tableau de bord">
        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <StatCard title="Projets totaux" :value="stats.total" icon="document-text" color="blue" />
            <StatCard title="Projets validés" :value="stats.valides" icon="check-circle" color="green" />
            <StatCard title="Projets rejetés" :value="stats.rejetes" icon="x-circle" color="red" />
            <StatCard title="Projets en attente" :value="stats.attente" icon="clock" color="yellow" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Graphique circulaire -->
            <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-1 min-h-100">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Répartition des projets</h2>
                <div class="h-64">
                    <DoughnutChart :chartData="chartData" :options="chartOptions" />
                </div>
            </div>

            <!-- Derniers projets -->
            <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Projets récents</h2>
                    <Link href="/projets" class="text-indigo-500 hover:text-indigo-700 text-sm font-medium">
                    Voir tous les projets
                    </Link>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Titre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="projet in paginatedProjets" :key="projet.id" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ projet.titre }}</div>
                                    <div class="text-sm text-gray-500">{{ truncate(projet.description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDate(projet.created_at) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <StatusBadge :status="projet.statut" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <Link :href="`/projets/${projet.id}`" class="text-indigo-500 hover:text-indigo-700">
                                    Détails
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="paginatedProjets.length === 0">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucun projet trouvé
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Affichage {{ startItem }}-{{ endItem }} sur {{ props.projets.length }} projets
                    </div>
                    <div class="flex space-x-2">
                        <button @click="prevPage" :disabled="currentPage === 1"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition"
                            :class="currentPage === 1 ? 'text-gray-400 bg-gray-100 cursor-not-allowed' : 'text-gray-700 bg-white hover:bg-gray-50'">
                            Précédent
                        </button>

                        <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
                            class="px-4 py-2 rounded-lg border font-medium text-sm transition"
                            :class="currentPage === page ? 'bg-indigo-500 text-white border-indigo-500' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50'">
                            {{ page }}
                        </button>

                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition"
                            :class="currentPage === totalPages ? 'text-gray-400 bg-gray-100 cursor-not-allowed' : 'text-gray-700 bg-white hover:bg-gray-50'">
                            Suivant
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from '@/Components/StatCard.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';

// Enregistrer les composants Chart.js
Chart.register(...registerables);

// Propriétés du composant
const props = defineProps({
    projets: {
        type: Array,
        default: () => []
    },
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            valides: 0,
            rejetes: 0,
            attente: 0
        })
    }
});

// Configuration de la pagination
const itemsPerPage = 3;
const currentPage = ref(1);

// Calcul du nombre total de pages
const totalPages = computed(() => {
    return Math.ceil(props.projets.length / itemsPerPage);
});

// Projets paginés
const paginatedProjets = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return props.projets.slice(startIndex, endIndex);
});

// Calcul des indices pour l'affichage "X-Y sur Z éléments"
const startItem = computed(() => {
    if (props.projets.length === 0) return 0;
    return (currentPage.value - 1) * itemsPerPage + 1;
});

const endItem = computed(() => {
    if (props.projets.length === 0) return 0;
    const end = currentPage.value * itemsPerPage;
    return end > props.projets.length ? props.projets.length : end;
});

// Méthodes de navigation dans la pagination
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

// Données pour le graphique circulaire
const chartData = computed(() => ({
    labels: ['Validés', 'Rejetés', 'En attente'],
    datasets: [
        {
            data: [props.stats.valides, props.stats.rejetes, props.stats.attente],
            backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
            hoverBackgroundColor: ['#059669', '#DC2626', '#D97706']
        }
    ]
}));

// Options du graphique
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    const label = context.label || '';
                    const value = context.raw || 0;
                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percentage = Math.round((value / total) * 100);
                    return `${label}: ${value} (${percentage}%)`;
                }
            }
        }
    }
};

// Utilitaires
function truncate(str, length) {
    if (!str) return '';
    return str.length > length ? str.substring(0, length) + '...' : str;
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
}
</script>
