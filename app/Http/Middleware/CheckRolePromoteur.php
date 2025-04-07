<?php

namespace App\Http\Middleware;

use App\Models\Projet;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRolePromoteur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Récupère l'ID du projet depuis la route
        $projetId = $request->route('projet');

        // Si pas d'ID de projet trouvé, on bloque
        if (!$projetId) {
            return redirect()->route('projets.index')
                ->with('error', 'Accès non autorisé');
        }

        // Trouve le projet
        $projet = Projet::find($projetId);

        // Si le projet n'existe pas, on bloque
        if (!$projet) {
            return redirect()->route('projets.index')
                ->with('error', 'Projet introuvable');
        }

        // Vérifie que l'utilisateur est bien le propriétaire du projet
        if ($projet->user_id !== $user->id) {
            return redirect()->route('projets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce projet');
        }

        return $next($request);
    }
}
