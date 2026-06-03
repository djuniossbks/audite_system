@extends('layouts.app')

@section('title', 'Données')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Liste des données</h1>
    <a class="btn btn-success" href="{{ route('donnees.create') }}"><i class="bi bi-plus-circle me-1"></i>Ajouter</a>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Titre</th><th>Utilisateur</th><th>Créé le</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donnees as $donnee)
                    <tr>
                        <td>{{ $donnee->id }}</td>
                        <td>{{ $donnee->titre }}</td>
                        <td>{{ $donnee->utilisateur->name }}</td>
                        <td>{{ $donnee->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('donnees.show', $donnee) }}"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->isAdmin())
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('donnees.edit', $donnee) }}"><i class="bi bi-pencil"></i></a>
                                <form class="d-inline" method="POST" action="{{ route('donnees.destroy', $donnee) }}" onsubmit="return confirm('Supprimer cette donnée ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune donnée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $donnees->links() }}</div>
</div>
@endsection
