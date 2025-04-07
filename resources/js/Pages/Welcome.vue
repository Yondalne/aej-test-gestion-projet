<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="font-jost bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">
        <!-- Header -->
        <header class="absolute top-0 left-0 w-full bg-transparent z-10">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="logo text-2xl font-bold text-white">ProNova</div>
                <div class="flex space-x-4">
                    <Link href="/login" class="px-4 py-2 text-white hover:text-gray-200 font-medium">Connexion</Link>
                    <Link href="/register"
                        class="px-4 py-2 bg-white text-indigo-700 rounded-lg hover:bg-gray-100 transition duration-300 font-medium">S'enregistrer</Link>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-12 md:py-20 relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient-move">
            </div>
            <div class="relative container mx-auto md:w-full lg:w-[80%] mt-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 px-8 mb-8 md:mb-0">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                            Transformez vos idées en projets concrets
                        </h1>
                        <p class="text-xl text-indigo-100 mb-8">
                            ProNova vous accompagne dans toutes les étapes de votre projet, de
                            la conception à la réalisation.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <Link href="/register"
                                class="bg-white hover:bg-indigo-50 text-indigo-700 text-center py-3 px-6 rounded-lg text-lg font-semibold transition duration-300">
                                Soumettre un projet
                            </Link>
                            <Link href="#"
                                class="border border-white text-white hover:bg-white hover:text-indigo-700 text-center py-3 px-6 rounded-lg text-lg font-semibold transition duration-300">
                                En savoir plus
                            </Link>
                        </div>
                    </div>
                    <div class="md:w-1/2 px-8 lg:px-0">
                        <img src="images/hero.jpg" alt="Collaboration d'équipe" class="rounded-lg shadow-lg w-full" />
                    </div>
                </div>
            </div>
        </section>


        <!-- Features Section -->
        <section class="py-16 bg-gradient-to-b from-gray-50 to-indigo-50">
            <div class="container mx-auto px-6 lg:px-32">
                <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-16">
                    Comment ça fonctionne
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Feature 1 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                            Proposez votre projet
                        </h3>
                        <p class="text-gray-600 text-center">
                            Décrivez votre idée, définissez vos objectifs et soumettez votre
                            projet sur notre plateforme.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                            Validation & Sélection
                        </h3>
                        <p class="text-gray-600 text-center">
                            Nos experts examinent votre proposition et évaluent sa faisabilité
                            et son potentiel.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                            Accompagnement
                        </h3>
                        <p class="text-gray-600 text-center">
                            Bénéficiez de conseils personnalisés, de formations et de
                            ressources pour concrétiser votre projet.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-16 bg-gradient-to-b from-indigo-50 to-white">
            <div class="container mx-auto px-6 lg:px-32">
                <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-16">
                    Ils nous font confiance
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                    <!-- Testimonial 1 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <p class="text-gray-600 italic mb-6">
                            "Grâce à ProNova, j'ai pu transformer mon idée en entreprise
                            viable en seulement 6 mois. L'accompagnement a été déterminant."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full mr-4 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">S</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Sophie Martin</h4>
                                <p class="text-sm text-gray-500">Fondatrice, EcoDesign</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <p class="text-gray-600 italic mb-6">
                            "Le processus de validation m'a permis d'affiner mon projet et de
                            le rendre beaucoup plus solide. Un gain de temps incroyable."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full mr-4 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">T</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Thomas Dubois</h4>
                                <p class="text-sm text-gray-500">CEO, TechSolutions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <p class="text-gray-600 italic mb-6">
                            "Le réseau de partenaires de ProNova m'a ouvert des portes que je
                            n'aurais jamais pu ouvrir seul. Une véritable communauté."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full mr-4 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">C</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Claire Leroy</h4>
                                <p class="text-sm text-gray-500">Directrice, InnoHealth</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-indigo-700 via-purple-700 to-pink-700 text-white">
            <div class="container mx-auto px-6 lg:px-32 text-center">
                <h2 class="text-4xl font-extrabold mb-6">Prêt à transformer vos idées en réalité ?</h2>
                <p class="text-lg md:text-xl text-indigo-100 mb-8 max-w-3xl mx-auto">
                    Rejoignez une communauté dynamique de créateurs et d'innovateurs pour donner vie à vos projets avec
                    le soutien qu'ils méritent.
                </p>
                <Link href="/register"
                    class="bg-white text-indigo-700 hover:bg-indigo-50 py-4 px-10 rounded-full text-lg font-semibold transition duration-300 inline-block shadow-lg hover:shadow-xl">
                    Commencer maintenant
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="container mx-auto px-4 lg:px-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- About Section -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">ProNova</h3>
                        <p class="mb-4 leading-relaxed">
                            La plateforme qui accompagne les porteurs de projets innovants, de
                            l'idée à la réalisation, avec des outils et un réseau adaptés.
                        </p>
                        <Link href="/about" class="text-indigo-400 hover:text-indigo-300 transition duration-300">
                            En savoir plus →
                        </Link>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Liens rapides</h4>
                        <ul class="space-y-2">
                            <li>
                                <Link href="/about" class="hover:text-indigo-300 transition duration-300">À propos</Link>
                            </li>
                            <li>
                                <Link href="/contact" class="hover:text-indigo-300 transition duration-300">Contact</Link>
                            </li>
                            <li>
                                <Link href="/services" class="hover:text-indigo-300 transition duration-300">Services</Link>
                            </li>
                            <li>
                                <Link href="/privacy" class="hover:text-indigo-300 transition duration-300">Politique de
                                    confidentialité</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Ressources</h4>
                        <ul class="space-y-2">
                            <li>
                                <Link href="/blog" class="hover:text-indigo-300 transition duration-300">Blog</Link>
                            </li>
                            <li>
                                <Link href="/guides" class="hover:text-indigo-300 transition duration-300">Guides</Link>
                            </li>
                            <li>
                                <Link href="/faq" class="hover:text-indigo-300 transition duration-300">FAQ</Link>
                            </li>
                            <li>
                                <Link href="/testimonials"
                                    class="hover:text-indigo-300 transition duration-300">Témoignages</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Contact</h4>
                        <ul class="space-y-2">
                            <li>
                                <Link href="mailto:contact@pronova.com"
                                    class="hover:text-indigo-300 transition duration-300">contact@pronova.com</Link>
                            </li>
                            <li>
                                <Link href="tel:+33123456789" class="hover:text-indigo-300 transition duration-300">+33 1
                                    23 45 67 89</Link>
                            </li>
                            <li>123 Avenue de l'Innovation</li>
                            <li>75001 Paris, France</li>
                        </ul>
                        <div class="mt-4 flex space-x-4">
                            <Link href="#" class="text-gray-400 hover:text-indigo-300 transition duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </Link>
                            <Link href="#" class="text-gray-400 hover:text-indigo-300 transition duration-300">
                                <i class="fab fa-twitter"></i>
                            </Link>
                            <Link href="#" class="text-gray-400 hover:text-indigo-300 transition duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </Link>
                            <Link href="#" class="text-gray-400 hover:text-indigo-300 transition duration-300">
                                <i class="fab fa-instagram"></i>
                            </Link>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p>&copy; 2025 ProNova. Tous droits réservés.</p>
                    <p class="text-sm mt-2">
                        <Link href="/terms" class="hover:text-indigo-300 transition duration-300">Conditions
                            d'utilisation</Link> |
                        <Link href="/privacy" class="hover:text-indigo-300 transition duration-300">Politique de
                            confidentialité</Link>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>


<style>
@import url("https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap");

* {
    font-family: "Jost", sans-serif;
}

@keyframes gradientMove {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.animate-gradient-move {
    background-size: 200% 200%;
    animation: gradientMove 10s ease infinite;
}
</style>
