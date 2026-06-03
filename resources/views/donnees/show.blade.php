@extends('layouts.app')

@section('title', 'Détail donnée')

@section('content')
<div class="card table-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">{{ $donnee->titre }}</span>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('donnees.index') }}">Retour</a>
    </div>
    <div class="card-body">
        <p class="text-muted mb-2">Créée par {{ $donnee->utilisateur->name }} le {{ $donnee->created_at?->format('d/m/Y H:i') }}</p>
        <p class="mb-0">{{ $donnee->description }}</p>
    </div>
</div>
@endsection
