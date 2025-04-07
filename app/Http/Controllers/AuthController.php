<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login', [
            'errors' => session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object) [],
        ]);
    }

    public function showRegisterForm() {
        return Inertia::render('Auth/Register', [
            'errors' => session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object) [],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }
    public function register(Request $request)
    {

        try {
            // Validation
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
                'date_naissance' => 'required|date',
                'lieu_naissance' => 'required|string|max:255',
                'numero_cni' => 'required|string|max:255',
                'cni_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'terms' => 'required|accepted',
            ]);

            // Gérer les uploads de fichiers
            $cniPath = null;
            $photoPath = null;

            if ($request->hasFile('cni_file')) {
                try {
                    $cniPath = $request->file('cni_file')->store('cni', 'public');
                } catch (\Exception $e) {
                    throw $e;
                }
            }

            if ($request->hasFile('photo')) {
                try {
                    $photoPath = $request->file('photo')->store('photos', 'public');
                } catch (\Exception $e) {
                    throw $e;
                }
            }

            // Créer l'utilisateur
            $userData = [
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'numero_cni' => $request->numero_cni,
                'cni_path' => $cniPath,
                'photo_path' => $photoPath,
                'forme_juridique' => $request->forme_juridique,
                'role' => 'promoteur',
            ];

            $user = User::create($userData);

            // Connexion automatique
            Auth::login($user);

            // Redirection
            return redirect()->intended('/dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // On relance l'exception pour qu'Inertia puisse la traiter
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['database' => 'Erreur lors de la création du compte. Veuillez réessayer.']);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
