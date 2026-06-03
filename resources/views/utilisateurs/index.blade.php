@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Liste des utilisateurs</h1>
    <a class="btn btn-success" href="{{ route('utilisateurs.create') }}"><i class="bi bi-plus-circle me-1"></i>Ajouter</a>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Créé le</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($utilisateurs as $utilisateur)
                    <tr>
                        <td>{{ $utilisateur->id }}</td>
                        <td>{{ $utilisateur->name }}</td>
                        <td>{{ $utilisateur->email }}</td>
                        <td><span class="badge {{ $utilisateur->role === 'admin' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $utilisateur->role }}</span></td>
                        <td>{{ $utilisateur->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('utilisateurs.edit', $utilisateur) }}"><i class="bi bi-pencil"></i></a>
                            <form class="d-inline" method="POST" action="{{ route('utilisateurs.destroy', $utilisateur) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $utilisateurs->links() }}</div>
</div>
@endsection
