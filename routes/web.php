<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonneeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
