@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center px-3" style="background: linear-gradient(135deg, #111827 0%, #1f2937 48%, #0f766e 100%);">
    <div class="row w-100 align-items-center justify-content-center g-0" style="max-width: 980px;">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="text-white pe-5">
                <div class="brand-mark mb-4"><i class="bi bi-shield-lock-fill fs-4"></i></div>
                <h1 class="display-6 fw-bold mb-3">Audit System</h1>
                <p class="lead text-white-50 mb-4">Console sécurisée pour piloter les utilisateurs, les données et les traces d'activité.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,.10);">
                            <i class="bi bi-lock-fill text-info"></i>
                            <div class="fw-semibold mt-2">Accès contrôlé</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,.10);">
                            <i class="bi bi-activity text-warning"></i>
                            <div class="fw-semibold mt-2">Audit complet</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 1rem;">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <span class="badge text-bg-success mb-3">Connexion sécurisée</span>
                        <h2 class="h3 fw-bold mb-1">Bienvenue</h2>
                        <p class="text-muted mb-0">Connectez-vous à votre espace de gestion.</p>
                    </div>
                    @include('partials.alerts')
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-key"></i></span>
                                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <button class="btn btn-success w-100 py-2" type="submit">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
