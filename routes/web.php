<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonneeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Route temporaire sécurisée pour créer manuellement votre premier compte Administrateur
Route::get('/creer-mon-admin', function () {
    if (!User::where('email', 'djuniossbks@gmail.com')->exists()) {
        User::create([
            'name' => 'Djunioss',
            'email' => 'djuniossbks@gmail.com',
            // Va chercher automatiquement le mot de passe Aiven configuré sur Render
            'password' => Hash::make(env('DB_PASSWORD')), 
            'role' => 'admin', // Configure le rôle d'administrateur pour votre middleware
        ]);
        return "Compte administrateur créé avec succès ! Vous pouvez maintenant vous connecter.";
    }
    return "L'utilisateur existe déjà.";
});

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('donnees', DonneeController::class)
        ->parameters(['donnees' => 'donnee'])
        ->except(['edit', 'update', 'destroy']);

    Route::middleware('role:admin')->group(function (): void {
        Route::get('/donnees/{donnee}/edit', [DonneeController::class, 'edit'])->name('donnees.edit');
        Route::put('/donnees/{donnee}', [DonneeController::class, 'update'])->name('donnees.update');
        Route::delete('/donnees/{donnee}', [DonneeController::class, 'destroy'])->name('donnees.destroy');
        Route::resource('utilisateurs', UserController::class)
            ->parameters(['utilisateurs' => 'utilisateur'])
            ->except(['show']);
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
    });
});
