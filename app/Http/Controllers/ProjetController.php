<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Projet;
use App\Models\User;
use App\Notifications\ProjetStatusNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifier si l'utilisateur est admin ou promoteur
        $user = Auth::user();
        $query = Projet::query()->with('user');

        // Les promoteurs ne peuvent voir que leurs propres projets
        if ($user->role === 'promoteur') {
            $query->where('user_id', $user->id);
        }

        // Appliquer les filtres de recherche si présents
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('promoteur')) {
            $promoteur = $request->input('promoteur');
            $query->whereHas('user', function ($q) use ($promoteur) {
                $q->where('nom', 'like', "%{$promoteur}%")
                  ->orWhere('prenoms', 'like', "%{$promoteur}%");
            });
        }

        if ($request->has('type') && $request->input('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->has('statut') && $request->input('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        // Récupérer les projets avec pagination
        $projets = $query->latest()->paginate(10)->withQueryString();

        // Préparer les statistiques
        $stats = [
            'total' => Projet::when($user->role === 'promoteur', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
            'valides' => Projet::when($user->role === 'promoteur', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'Validé')->count(),
            'rejetes' => Projet::when($user->role === 'promoteur', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'Rejeté')->count(),
            'attente' => Projet::when($user->role === 'promoteur', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'En Attente')->count(),
        ];

        return Inertia::render('Admin/Projets/List', [
            'projets' => $projets,
            'stats' => $stats,
            'filters' => $request->only(['search', 'promoteur', 'type', 'statut']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Projets/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['En Développement', 'En Création'])],
            'forme_juridique' => ['required', Rule::in([
                'PME & Startup',
                'Grandes Entreprises',
                'Administration Publiques',
                'Cabinets de Recrutement',
                'Organisme de Recrutement',
                'Structure Accompagnement'
            ])],
            'plan_affaire' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        // Stockage du fichier PDF
        $planAffairePath = $request->file('plan_affaire')->store('plans_affaires', 'public');

        // Création du projet
        $projet = new Projet([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'forme_juridique' => $validated['forme_juridique'],
            'plan_affaire_path' => $planAffairePath,
            'statut' => 'En Attente', // Statut par défaut
        ]);

        // Associer le projet à l'utilisateur actuel
        $projet->user()->associate(Auth::user());
        $projet->save();

        $projet->user->notify(new ProjetStatusNotification($projet));

        return redirect()->route('projets.index')
            ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projet = Projet::with('user')->findOrFail($id);

        return Inertia::render('Admin/Projets/Show', [
            'projet' => $projet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $projet = Projet::findOrFail($id);

        return Inertia::render('Admin/Projets/Edit', [
            'projet' => $projet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projet = Projet::findOrFail($id);

        // Validation de base pour tous les utilisateurs
        $rules = [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['En Développement', 'En Création'])],
            'forme_juridique' => ['required', Rule::in([
                'PME & Startup',
                'Grandes Entreprises',
                'Administration Publiques',
                'Cabinets de Recrutement',
                'Organisme de Recrutement',
                'Structure Accompagnement'
            ])],
            'plan_affaire' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
        ];

        // Règles supplémentaires pour les administrateurs
        if (Auth::user()->role === 'admin') {
            $rules['statut'] = ['required', Rule::in(['En Attente', 'Validé', 'Rejeté'])];

            // Justification obligatoire si le projet est rejeté
            if ($request->input('statut') === 'Rejeté') {
                $rules['justification_rejet'] = 'required|string';
            }
        }

        $validated = $request->validate($rules);

        // Mise à jour des champs de base
        $projet->titre = $validated['titre'];
        $projet->description = $validated['description'];
        $projet->type = $validated['type'];
        $projet->forme_juridique = $validated['forme_juridique'];
        // En cas de modification après rejet, mettre à jour le statut => "En Attente" et vider justification
        $projet->statut = "En Attente";
        $projet->justification_rejet = null;

        // Mise à jour du statut et justification (admin uniquement)
        if (Auth::user()->role === 'admin') {
            $projet->statut = $validated['statut'];

            if ($validated['statut'] === 'Rejeté') {
                $projet->justification_rejet = $validated['justification_rejet'];
            } elseif ($validated['statut'] !== 'Rejeté') {
                $projet->justification_rejet = null;
            }
        }

        // Traitement du nouveau fichier s'il est fourni
        if ($request->hasFile('plan_affaire')) {
            // Supprimer l'ancien fichier
            if ($projet->plan_affaire_path) {
                Storage::disk('public')->delete($projet->plan_affaire_path);
            }

            // Stocker le nouveau fichier
            $projet->plan_affaire_path = $request->file('plan_affaire')->store('plans_affaires', 'public');
        }

        $projet->save();

        return redirect()->route('projets.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projet = Projet::findOrFail($id);

        // Supprimer le fichier associé
        if ($projet->plan_affaire_path) {
            Storage::disk('public')->delete($projet->plan_affaire_path);
        }

        $projet->delete();

        return redirect()->route('projets.index')
            ->with('success', 'Projet supprimé avec succès.');
    }

    /**
     * Télécharger le plan d'affaires
     */
    public function downloadPlan(string $id)
    {
        $projet = Projet::findOrFail($id);

        if (!$projet->plan_affaire_path) {
            abort(404, 'Fichier introuvable');
        }

        return Storage::disk('public')->download($projet->plan_affaire_path, 'plan_affaire_' . $projet->titre . '.pdf');
    }

    /**
     * Valider un projet
     */
    public function valider(string $id)
    {
        $projet = Projet::findOrFail($id);

        // Seuls les administrateurs peuvent valider un projet
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        // Vérifier que le projet est en attente
        if ($projet->statut !== 'En Attente') {
            return redirect()->back()->with('error', 'Seuls les projets en attente peuvent être validés.');
        }

        $projet->statut = 'Validé';
        $projet->justification_rejet = null; // Effacer toute justification précédente
        $projet->save();

        // Envoyer la notification
        $projet->user->notify(new ProjetStatusNotification($projet));

        return redirect()->route('projets.show', $projet->id)
            ->with('success', 'Le projet a été validé avec succès.');
    }

    /**
     * Rejeter un projet
     */
    public function rejeter(Request $request, string $id)
    {
        $projet = Projet::findOrFail($id);

        // Seuls les administrateurs peuvent rejeter un projet
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        // Vérifier que le projet est en attente
        if ($projet->statut !== 'En Attente') {
            return redirect()->back()->with('error', 'Seuls les projets en attente peuvent être rejetés.');
        }

        // Valider la justification
        $validated = $request->validate([
            'justification_rejet' => 'required|string|min:10|max:500',
        ], [
            'justification_rejet.required' => 'La justification du rejet est requise.',
            'justification_rejet.min' => 'La justification doit contenir au moins 10 caractères.',
            'justification_rejet.max' => 'La justification ne peut pas dépasser 500 caractères.'
        ]);

        $projet->statut = 'Rejeté';
        $projet->justification_rejet = $validated['justification_rejet'];
        $projet->save();

        // Envoyer la notification
        $projet->user->notify(new ProjetStatusNotification($projet));

        return redirect()->route('projets.show', $projet->id)
            ->with('success', 'Le projet a été rejeté avec succès.');
    }

    public function exportPdf(string $id) {
        if ($id == 'all') {
            return $this->exportPdfAll();
        } elseif(!empty($id)) {
            return $this->exportPdfSingle($id);
        } else {
            return redirect()->back()->with('error', 'Aucun projet trouvé.');
        }
    }
    public function exportPdfSingle(string $id)
    {
        $projet = Projet::with('user')->findOrFail($id);

        // Vérifier que l'utilisateur a le droit d'accéder à ce projet
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $projet->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à ce projet.');
        }

        if (!empty($projet->resume_path)) {
            return Storage::disk('public')->download($projet->resume_path, 'resume_projet_' . $projet->id . '_' . str_replace(' ', '_', $projet->titre) . '.pdf');
        } else {
            // Générer le PDF avec la vue
            $pdf = Pdf::loadView('pdfs.projet-single', ['projet' => $projet]);

            // Options du PDF
            $pdf->setPaper('a4');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'debugCss' => false
            ]);

            // Sauvegarder le PDF dans le stockage
            $fileName = 'resume_projet_' . $projet->id . '_' . str_replace(' ', '_', $projet->titre) . '.pdf';
            $filePath = 'resumes/' . $fileName;
            Storage::disk('public')->put($filePath, $pdf->output());

            // Mettre à jour le chemin du résumé dans le projet
            $projet->resume_path = $filePath;
            $projet->save();

            // Télécharger le PDF
            return $pdf->download($fileName);
        }

        // Afficher le PDF dans le navigateur:
        // return $pdf->stream('projet_'.$projet->id.'_'.str_replace(' ', '_', $projet->titre).'.pdf');
    }

    public function exportPdfAll()
    {
        $projets = Projet::where('statut', 'Validé')->with('user')->get(); // Utilisation d'eager loading pour optimiser

        // Configurer des options plus spécifiques pour résoudre les problèmes d'encodage
        $options = [
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'dejavu sans',
            'fontDir' => public_path('fonts/'),
            'fontCache' => storage_path('fonts/'),
            'dpi' => 150,
            'debugCss' => false,
            'enable_php' => false, // Désactiver l'exécution PHP est souvent plus sûr
            'orientation' => 'portrait',
            'encoding' => 'UTF-8', // Spécifier explicitement l'encodage
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ];

        // Utiliser try/catch pour capturer les erreurs potentielles
        try {
            // Générer le PDF avec la vue et les options
            $pdf = PDF::loadView('pdfs.projet-all', ['projets' => $projets]);
            $pdf->setPaper('a4');
            $pdf->setOptions($options);

            // Télécharger le PDF
            return $pdf->download('liste_projets_' . now()->format('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur de génération PDF: ' . $e->getMessage());

            // Rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'Impossible de générer le PDF. Veuillez réessayer plus tard.');
        }
    }
}
