<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjetController;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\CheckRolePromoteur;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', HandleInertiaRequests::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Route resource avec middleware spécifique sur certaines méthodes
    Route::resource('projets', ProjetController::class)->except(['edit', 'update', 'destroy']);

    // Routes spécifiques avec middleware checkrole
    Route::middleware([CheckRolePromoteur::class])->group(function () {
        Route::get('/projets/{projet}/edit', [ProjetController::class, 'edit'])->name('projets.edit');
        Route::put('/projets/{projet}', [ProjetController::class, 'update'])->name('projets.update');
        Route::patch('/projets/{projet}', [ProjetController::class, 'update']);
        Route::delete('/projets/{projet}', [ProjetController::class, 'destroy'])->name('projets.destroy');
    });

    Route::get('/projets/export-pdf/{id}', [ProjetController::class, 'exportPdf'])->name('projets.export-pdf');

    // Route pour télécharger le plan d'affaires
    Route::get('/projets/{projet}/download', [ProjetController::class, 'downloadPlan'])->name('projets.download');

    // Routes spécifiques avec middleware CheckRoleAdmin
    Route::middleware([CheckRoleAdmin::class])->group(function () {
        // Route pour Valider ou rejeter un projet
        Route::patch('/projets/{id}/valider', [ProjetController::class, 'valider'])->name('projets.valider');
        Route::patch('/projets/{id}/rejeter', [ProjetController::class, 'rejeter'])->name('projets.rejeter');
    });
});



