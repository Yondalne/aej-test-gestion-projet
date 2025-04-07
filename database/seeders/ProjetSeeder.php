<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projets = [
            [
                'user_id' => 1,
                'titre' => "Plateforme e-commerce",
                'description' => "Développement d'une plateforme de vente en ligne pour les produits artisanaux locaux avec système de paiement intégré.",
                'statut' => "Validé",
                'plan_affaire_path' => 'path/to/plan_affaire1.pdf',
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(55),
            ],
            [
                'user_id' => 1,
                'titre' => "Application mobile de livraison",
                'description' => "Création d'une application permettant de suivre en temps réel les livraisons de colis dans la région.",
                'statut' => "Validé",
                'plan_affaire_path' => 'path/to/plan_affaire2.pdf',
                'created_at' => Carbon::now()->subDays(45),
                'updated_at' => Carbon::now()->subDays(40),
            ],
            [
                'user_id' => 1,
                'titre' => "Système de gestion d'inventaire",
                'description' => "Mise en place d'un logiciel de gestion des stocks pour un réseau de boutiques.",
                'statut' => "Rejeté",
                'plan_affaire_path' => 'path/to/plan_affaire3.pdf',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'user_id' => 1,
                'titre' => "Plateforme de formation en ligne",
                'description' => "Création d'une plateforme LMS pour dispenser des cours à distance avec suivi des progrès.",
                'statut' => "En Attente",
                'plan_affaire_path' => 'path/to/plan_affaire4.pdf',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_id' => 1,
                'titre' => "Application de gestion de projet",
                'description' => "Développement d'un outil interne pour suivre l'avancement des projets et la répartition des tâches.",
                'statut' => "En Attente",
                'plan_affaire_path' => 'path/to/plan_affaire5.pdf',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 1,
                'titre' => "Refonte graphique site institutionnel",
                'description' => "Modernisation de l'interface utilisateur et amélioration de l'expérience utilisateur d'un site existant.",
                'statut' => "Validé",
                'plan_affaire_path' => 'path/to/plan_affaire6.pdf',
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(85),
            ],
            [
                'user_id' => 1,
                'titre' => "Système de réservation en ligne",
                'description' => "Création d'un système permettant aux clients de réserver des services avec paiement d'acompte.",
                'statut' => "Rejeté",
                'plan_affaire_path' => 'path/to/plan_affaire7.pdf',
                'created_at' => Carbon::now()->subDays(75),
                'updated_at' => Carbon::now()->subDays(70),
            ],
            [
                'user_id' => 1,
                'titre' => "Plateforme collaborative interne",
                'description' => "Mise en place d'un intranet pour faciliter la communication et le partage de documents entre équipes.",
                'statut' => "En Attente",
                'plan_affaire_path' => 'path/to/plan_affaire8.pdf',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => 1,
                'titre' => "Application de suivi fitness",
                'description' => "Développement d'une application mobile permettant de suivre les entraînements et les progrès sportifs.",
                'statut' => "En Attente",
                'plan_affaire_path' => 'path/to/plan_affaire9.pdf',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        DB::table('projets')->insert($projets);
    }
}
