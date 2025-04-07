<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Récupérer tous les projets triés par date de création (les plus récents d'abord)
        $projets = auth()->user()->role == 'admin' ? Projet::orderBy('created_at', 'desc')->get() : auth()->user()->projets()->orderBy('created_at', 'desc')->get();

        // Calculer les statistiques
        $stats = [
            'total' => $projets->count(),
            'valides' => $projets->where('statut', 'Validé')->count(),
            'rejetes' => $projets->where('statut', 'Rejeté')->count(),
            'attente' => $projets->where('statut', 'En Attente')->count(),
        ];

        // Rendre la vue avec les données
        return Inertia::render('Admin/Dashboard', [
            'projets' => $projets,
            'stats' => $stats,
        ]);
    }
}
